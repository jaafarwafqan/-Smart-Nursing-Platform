@props([
    'name'          => 'attachments[]',
    'accept'        => '.jpg,.gif,.png,.jpeg,.pdf,.mp4,.mov,.avi,.webm,.mkv',
    'multiple'      => true,
    'label'         => 'رفع الملفات',
    'placeholder'   => 'اسحب وأفلت الملفات هنا أو انقر للاختيار',
    'currentFiles'  => [],
    'deleteRoute'   => null,
    'modelId'       => null
])

@php
    $inputId = 'file-upload-' . uniqid();
@endphp

<div class="text-danger fw-bold mb-2 text-center" style="font-size: 15px;">
    * الصيغ المسموحة: JPG, GIF, PNG, JPEG, PDF, MP4, MOV, AVI, WEBM, MKV
    <span style="color:#d32f2f"> (حجم الفيديو الأقصى: 50 ميجابايت)</span>
</div>
<div x-data="fileUpload()" x-cloak class="mb-4">
    <div id="toast-container" style="position: absolute; top: 10px; left: 50%; transform: translateX(-50%); z-index: 9999;"></div>
    <div
        @dragover.prevent="isDragging = true"
        @dragleave.prevent="isDragging = false"
        @drop.prevent="handleDrop($event)"
        class="file-upload-area d-flex flex-column justify-content-center align-items-center"
        style="background: #f7fafc; border: 2px dashed #b0bec5; border-radius: 16px; min-height: 220px; padding: 40px 10px; transition: border-color 0.2s; text-align: center;">
        <i class="fas fa-cloud-upload-alt fa-3x mb-3" style="color: #607d8b;"></i>
        <div class="mb-2" style="color: #455a64; font-size: 22px; font-weight: 500;">قم بسحب الملفات وإفلاتها هنا ...</div>
        <div class="mb-3" style="color: #90a4ae; font-size: 15px;">أو قم بتحميلها من جهازك</div>
        <label class="form-label fw-semibold" for="{{ $inputId }}">
            <i class="fas fa-file-upload me-1"></i>
            {{ $label }}
        </label>
        <input
            type="file"
            class="d-none"
            x-ref="fileInput"
            id="{{ $inputId }}"
            name="{{ $name }}"
            accept="{{ $accept }}"
            {{ $multiple ? 'multiple' : '' }}
            @change="handleFileSelect($event)">
        <button type="button" class="btn btn-primary mt-2" @click="$refs.fileInput.click()">
            <i class="fas fa-upload me-2"></i>
            اختيار الملفات
        </button>
    </div>

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
                        <button type="button" class="btn btn-sm btn-outline-danger" @click="removeFile(index)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </template>

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
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeAttachment('{{ $file }}', '{{ $modelId }}')">
                                <i class="fas fa-times"></i>
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script>
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `custom-toast alert alert-${type} fade show`;
            toast.style.minWidth = '200px';
            toast.innerHTML = `<span>${message}</span>`;
            document.getElementById('toast-container').appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }

        function fileUpload() {
            const allowedTypes = [
                'application/pdf',
                'image/jpeg', 'image/png', 'image/jpg', 'image/gif',
                'video/mp4', 'video/quicktime', 'video/x-msvideo', 'video/webm', 'video/x-matroska'
            ];
            return {
                isDragging: false,
                selectedFiles: [],
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
                addFiles(files) {
                    files.forEach(file => {
                        if (!allowedTypes.includes(file.type)) {
                            showToast('نوع ملف غير مدعوم: ' + file.name, 'danger');
                            return;
                        }
                        if (file.size > 50 * 1024 * 1024) {
                            showToast('الحجم الأقصى للملف 50 ميجابايت: ' + file.name, 'danger');
                            return;
                        }
                        this.selectedFiles.push({
                            id: crypto.randomUUID(),
                            file: file,
                            name: file.name,
                            size: file.size,
                            preview: file.type.startsWith('image/') ? URL.createObjectURL(file) : null,
                        });
                    });
                    this.refreshInput();
                },
                handleDrop(e) {
                    this.isDragging = false;
                    this.addFiles([...e.dataTransfer.files]);
                },
                handleFileSelect(e) {
                    this.addFiles([...e.target.files]);
                },
                removeFile(index) {
                    const removed = this.selectedFiles.splice(index, 1)[0];
                    if (removed?.preview) URL.revokeObjectURL(removed.preview);
                    this.refreshInput();
                }
            }
        }

        function removeAttachment(filename, modelId) {
            if (!'{{ $deleteRoute }}') {
                showToast('لم يتم تعريف مسار الحذف!', 'danger');
                return;
            }
            if (!confirm('هل أنت متأكد من حذف هذا المرفق؟')) return;
            let url = `{{ $deleteRoute ? route($deleteRoute, [':modelId', ':filename']) : '' }}`;
            url = url.replace(':modelId', modelId).replace(':filename', encodeURIComponent(filename));
            axios.delete(url)
                .then(({data}) => {
                    showToast(data.message || 'تم الحذف بنجاح', 'success');
                    document.querySelector(`[data-filename="${filename}"]`)?.remove();
                })
                .catch(err => showToast(err.response?.data?.message || 'حدث خطأ أثناء حذف المرفق', 'danger'));
        }
    </script>
@endpush
