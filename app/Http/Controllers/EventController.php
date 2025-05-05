<?php

namespace App\Http\Controllers;

use App\Contracts\EventServiceInterface;
use App\Models\Event;
use App\Models\Branch;
use App\Services\EventService;
use App\Http\Requests\StoreEventRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\View\View;

class EventController extends Controller
{
    public function __construct(private EventServiceInterface $service)
    {
        // يفعّل صلاحيات EventPolicy لكل دالة تلقائيًا
        $this->authorizeResource(Event::class, 'event');
    }

    /** عرض جميع الفعاليات */
    public function index(Request $request)
    {
        $events = Event::query()
            ->when($request->event_type, fn($q,$v)=>$q->where('event_type',$v))
            ->when($request->event_title,fn($q,$v)=>$q->where('event_title','like',"%$v%"))
            ->when($request->branch_id, fn($q,$v)=>$q->where('branch_id',$v))
            ->orderBy($request->get('sort','event_datetime'), $request->get('direction','desc'))
            ->paginate(15);

        $stats = [
            'total'            => Event::count(),
            'upcoming'         => Event::where('event_datetime','>',now())->count(),
            'attendance_sum'   => Event::sum('attendance'),
            'attendance_avg'   => round(Event::avg('attendance')),
        ];

        return view('events.index', [
            'events'      => $events,
            'stats'       => $stats,
            'eventTypes'  => config('types.event_types',[]),
            'branches'    => config('branches',[]),
        ]);
    }


    /** نموذج إنشاء فعاليّة */
    public function create()
    {
        return view('events.create', [
            'event'      => null,
            'branches' => \App\Models\Branch::pluck('name', 'id'),          // id => name
            'eventTypes' => Config::get('types.event_types', []),   // ['ندوة','ورشة'…]
        ]);
    }

    public function edit(Event $event)
    {
        return view('events.edit', [
            'event'      => $event,
            'branches' => \App\Models\Branch::pluck('name', 'id'),
            'eventTypes' => Config::get('types.event_types', []),

        ]);
    }

    /** تخزين فعاليّة جديدة */
    public function store(StoreEventRequest $request): RedirectResponse
    {
        $event = $this->service->create($request->validated());
        return to_route('events.show', $event)
            ->withSuccess('تمّت إضافة الفعاليّة بنجاح');
    }
    public function show(Event $event): View
    {
        return view('events._form', [
            'event'      => $event,
            'branches'   => \App\Models\Branch::pluck('name', 'id'),
            'eventTypes' => \Illuminate\Support\Facades\Config::get('types.event_types', []),
        ]);
    }
    /** تحديث البيانات */
    public function update(StoreEventRequest $request, Event $event): RedirectResponse
    {
        $this->service->update($event, $request->validated());
        return back()->withSuccess('تمّ التحديث بنجاح');
    }

    /** حذف الفعاليّة */
    public function destroy(Event $event): RedirectResponse
    {
        $this->service->delete($event);
        return to_route('events.index')->withSuccess('تمّ الحذف');
    }
}
