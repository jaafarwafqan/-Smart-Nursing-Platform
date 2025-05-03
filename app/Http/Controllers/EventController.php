<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Branch;
use App\Services\EventService;
use App\Http\Requests\StoreEventRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventController extends Controller
{
    public function __construct(private EventService $service)
    {
        // يفعّل صلاحيات EventPolicy لكل دالة تلقائيًا
        $this->authorizeResource(Event::class, 'event');
    }

    /** عرض جميع الفعاليات */
    public function index(): View
    {
        $events = Event::with('branch')->latest()->paginate(10);
        $event_types = config('types.event_types', []);

        return view('events.index', compact('events', 'event_types'));

    }

    /** نموذج إنشاء فعاليّة */
    public function create(): View
    {
        $branches = Branch::pluck('name', 'id');
        return view('events.create', compact('branches'));
    }

    /** تخزين فعاليّة جديدة */
    public function store(StoreEventRequest $request): RedirectResponse
    {
        $event = $this->service->create($request->validated());
        return to_route('events.show', $event)
            ->withSuccess('تمّت إضافة الفعاليّة بنجاح');
    }

    /** صفحة عرض فعاليّة مفردة */
    public function show(Event $event): View
    {
        return view('events._form', compact('event'));
    }

    /** نموذج التعديل */
    public function edit(Event $event): View
    {
        $branches = Branch::pluck('name', 'id');
        return view('events.edit', compact('event', 'branches'));
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
