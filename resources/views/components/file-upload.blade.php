@props([
    'name'          => 'attachments[]',
    'accept'        => '.pdf,.doc,.docx,.jpg,.jpeg,.png',
    'multiple'      => true,
    'label'         => 'رفع الملفات',
    'placeholder'   => 'اسحب وأفلت الملفات هنا أو انقر للاختيار',
    'currentFiles'  => [],   /* مصفوفة مسارات الملفات الحالية */
    'deleteRoute'   => null, /* اسم الـ Route لحذف المرفق */
    'modelId'       => null  /* رقم الموديل للحذف */
])

{{--  ⚠️  ملاحظة: يتطلب Alpine.js و Axios و Font-Awesome مُحمّلة في الـLayout العام  --}}

<div x-data="fileUpload()" x-cloak class="card border-0 shadow-sm">
    <div class="card-body">
        <label class="form-label fw-semibold">
            <i class="fas fa-file-upload me-1"></i>
            {{ $label }}
        </label>

        <!-- منطقة السحب والإفلات / زر الاختيار -->
        <div
            @dragover.prevent="isDragging = true"
            @dragleave.prevent="isDragging = false"
            @drop.prevent="handleDrop($event)"
            :class="{'border-primary border-2 bg-light': isDragging}"
            class="file-upload-area border rounded p-4 text-center position-relative">
            <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
            <p class="text-muted mb-3">{{ $placeholder }}</p>

            <!-- input[type=file] مخفي -->
            <input
                type="file"
                class="d-none"
                x-ref="fileInput"
                name="{{ $name }}"
                accept="{{ $accept }}"
                {{ $multiple ? 'multiple' : '' }}
                @change="handleFileSelect($event)">

            <button type="button" class="btn btn-primary" @click="$refs.fileInput.click()">
                <i class="fas fa-upload me-2"></i>
                اختيار الملفات
            </button>
        </div>

        <!-- معاينة الملفات المختارة حديثاً -->
        <template x-if="selectedFiles.length">
            <div class="mt-4">
                <h6 class="mb-3 text-start">الملفات المختارة:</h6>
                <div class="list-group">
                    <template x-for="(item, index) in selectedFiles" :key="item.id">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <template x-if="item.preview">
                                    <img :src="item.preview" alt="preview" class="rounded" style="width:48px;height:48px;object-fit:cover">
                                </template>
                                <template x-if="!item.preview">
                                    <i class="fas fa-file text-primary fa-lg"></i>
                                </template>
                                <div>
                                    <div x-text="item.name"></div>
                                    <small class="text-muted" x-text="formatSize(item.size)"></small>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger" @click="removeFile(index)"><i class="fas fa-times"></i></button>
                        </div>
                    </template>
                </div>
            </div>
        </template>

        <!-- الملفات المرفقة سابقاً -->
        @if(count($currentFiles) > 0)
            <div class="mt-4">
                <h6 class="mb-3 text-start">الملفات المرفقة حالياً:</h6>
                <div class="list-group">
                    @foreach($currentFiles as $file)
                        <div class="list-group-item d-flex justify-content-between align-items-center" data-filename="{{ $file }}">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-file text-primary fa-lg"></i>
                                <span>{{ basename($file) }}</span>
                            </div>
                            @if($deleteRoute && $modelId)
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeAttachment('{{ $file }}', '{{ $modelId }}')"><i class="fas fa-times"></i></button>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
    <script>
        function fileUpload() {
            return {
                /* -------------------------------- state */
                isDragging   : false,
                selectedFiles: [],   // {id, file, name, size, preview}

                /* -------------------------------- helpers */
                formatSize(bytes) {
                    if (bytes === 0) return '0 Bytes';
                    const k = 1024, dm = 2, sizes = ['Bytes', 'KB', 'MB', 'GB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
                },

                refreshInput() {
                    const dt = new DataTransfer();
                    this.selectedFiles.forEach(item => dt.items.add(item.file));
                    this.$refs.fileInput.files = dt.files;
                },

                /* -------------------------------- actions */
                addFiles(files) {
                    files.forEach(file => {
                        this.selectedFiles.push({
                            id     : crypto.randomUUID(),
                            file   : file,
                            name   : file.name,
                            size   : file.size,
                            preview: file.type.startsWith('image/') ? URL.createObjectURL(file) : null,
                        });
                    });

                },
                handleDrop(e) {
                    this.isDragging = false;
                    this.$refs.fileInput.files = e.dataTransfer.files; // يعمل لأن المتصفح هو من يملأه
                    // عرض المعاينة فقط لأجل UX
                    this.selectedFiles = [...e.dataTransfer.files];
                },

                handleDrop(e) {
                    this.isDragging = false;
                    this.addFiles([...e.dataTransfer.files]);
                },
                removeFile(index) {
                    const removed = this.selectedFiles.splice(index, 1)[0];
                    if (removed?.preview) URL.revokeObjectURL(removed.preview);
                    this.refreshInput();
                }
            }
        }

        /* حذف مرفق من الخادم */
        function removeAttachment(filename, modelId) {
            if (!confirm('هل أنت متأكد من حذف هذا المرفق؟')) return;
            axios.delete(`{{ route('events.attachment.destroy', ['event' => ':modelId', 'filename' => ':filename']) }}`
                .replace(':modelId', modelId).replace(':filename', encodeURIComponent(filename)))
                .then(({data}) => {
                    alert(data.message || 'تم الحذف بنجاح');
                    document.querySelector(`[data-filename="${filename}"]`)?.remove();
                })
                .catch(err => alert(err.response?.data?.message || 'حدث خطأ أثناء حذف المرفق'));
        }
    </script>
@endpush
