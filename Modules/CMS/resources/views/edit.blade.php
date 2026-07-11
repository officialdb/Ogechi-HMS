<x-admin-layout title="Edit Post – {{ $post->title }}">
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Breadcrumb & Header --}}
    <div>
        <div class="flex items-center gap-2 text-xs text-slate-400 mb-3">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
            <x-fas-tachometer-alt class="w-3 h-3" />
            <a href="{{ route('modules.cms.index') }}" class="hover:text-blue-600 transition-colors">Blog / CMS</a>
            <x-fas-tachometer-alt class="w-3 h-3" />
            <span class="text-slate-600 font-semibold truncate max-w-[150px]">{{ $post->title }}</span>
            <x-fas-tachometer-alt class="w-3 h-3" />
            <span class="text-slate-600 font-semibold">Edit</span>
        </div>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Edit Post</h1>
                <p class="text-sm text-slate-500 mt-1">Update content and publishing settings.</p>
            </div>
            
            @if($post->approval_status === 'submitted')
                @can('cms.approve')
                <div class="flex items-center gap-2">
                    <form method="POST" action="{{ route('modules.cms.reject', $post) }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-sm font-bold text-red-600 bg-red-50 hover:bg-red-100 rounded-xl transition-colors">Reject</button>
                    </form>
                    <form method="POST" action="{{ route('modules.cms.approve', $post) }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-sm font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-xl transition-colors">Approve & Publish</button>
                    </form>
                </div>
                @endcan
            @endif
        </div>
    </div>

    @if($errors->any())
        <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium border border-red-100">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form id="cms-edit-form" method="POST" action="{{ route('modules.cms.update', $post) }}" enctype="multipart/form-data" class="bg-white border border-slate-100 shadow-sm rounded-2xl overflow-hidden">
        @csrf
        @method('PUT')
        
        <div class="p-6 sm:p-8 space-y-8">
            {{-- Content Section --}}
            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Article Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $post->title) }}" required 
                           class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400 font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">URL Slug <span class="text-red-500">*</span></label>
                    <div class="flex items-center gap-2 text-sm text-slate-500">
                        <span>{{ url('/blog') }}/</span>
                        <input type="text" name="slug" value="{{ old('slug', $post->slug) }}" required 
                               class="flex-1 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Category <span class="text-red-500">*</span></label>
                        <select name="category" required class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700">
                            @php $currCat = old('category', $post->category); @endphp
                            @foreach(['General Health','Cardiology','Neurology','Orthopedics','Dentistry','Endocrinology','Hospital News'] as $cat)
                                <option value="{{ $cat }}" {{ $currCat===$cat ? 'selected':'' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Read Time (optional)</label>
                        <input type="text" name="read_time" value="{{ old('read_time', $post->read_time) }}" 
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Thumbnail Image (optional)</label>
                    @if($post->thumbnail)
                        <div class="mb-3">
                            <img src="{{ Storage::url($post->thumbnail) }}" alt="Thumbnail" class="h-20 w-auto rounded-lg shadow-sm border border-slate-200">
                        </div>
                    @endif
                    <input type="file" name="thumbnail" accept="image/*"
                           class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-[10px] text-slate-400 mt-1.5">Leave blank to keep existing thumbnail.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Excerpt</label>
                    <textarea name="excerpt" rows="2" 
                              class="w-full px-4 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors placeholder-slate-400 resize-none">{{ old('excerpt', $post->excerpt) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Article Body <span class="text-red-500">*</span></label>
                    
                    {{-- Quill Editor Container --}}
                    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-400 transition-colors">
                        <div id="quill-editor" style="height: 350px; font-family: inherit; font-size: 14px;" class="text-slate-700 bg-slate-50 border-none">{!! old('body', $post->body) !!}</div>
                    </div>
                    
                    {{-- Hidden Input for form submission --}}
                    <input type="hidden" name="body" id="body-input" required value="{{ old('body', $post->body) }}">
                </div>
            </div>

            {{-- Metadata Section --}}
            <div class="border-t border-slate-100 pt-6">
                <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <div class="w-6 h-6 bg-violet-50 text-violet-600 rounded flex items-center justify-center"><x-fas-tachometer-alt class="w-3.5 h-3.5" /></div>
                    Publishing
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                        <select name="approval_status" required class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors text-slate-700 font-bold">
                            @php $currStatus = old('approval_status', $post->approval_status); @endphp
                            <option value="draft" {{ $currStatus==='draft' ? 'selected':'' }}>Draft (Hidden)</option>
                            <option value="submitted" {{ $currStatus==='submitted' ? 'selected':'' }}>Submit for Review</option>
                            @can('cms.approve')
                                <option value="approved" {{ $currStatus==='approved' ? 'selected':'' }}>Published (Live)</option>
                            @endcan
                            <option value="rejected" {{ $currStatus==='rejected' ? 'selected':'' }} disabled>Rejected</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="px-6 sm:px-8 py-5 bg-slate-50 border-t border-slate-100 flex items-center justify-between gap-3">
            <button type="button" x-data @click="if(confirm('Are you sure you want to delete this post?')) { document.getElementById('delete-post-form').submit(); }" class="px-4 py-2 text-xs font-bold text-red-600 hover:bg-red-50 rounded-xl transition-colors">
                Delete Post
            </button>
            <div class="flex items-center gap-3">
                <a href="{{ route('modules.cms.index') }}" class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-200 hover:bg-slate-100 rounded-xl transition-colors">Cancel</a>
                
                @if($post->approval_status === 'draft' || $post->approval_status === 'rejected')
                    <button type="button" onclick="document.querySelector('select[name=approval_status]').value='submitted'; document.getElementById('cms-edit-form').submit();" class="px-5 py-2.5 text-sm font-bold text-white rounded-xl shadow-md transition-all hover:opacity-90 bg-emerald-600">
                        Submit for Review
                    </button>
                @endif
                
                <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white rounded-xl shadow-md transition-all hover:opacity-90" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                    Save Changes
                </button>
            </div>
        </div>
    </form>

    {{-- Hidden Delete Form --}}
    <form id="delete-post-form" method="POST" action="{{ route('modules.cms.destroy', $post) }}" class="hidden">
        @csrf
        @method('DELETE')
    </form>

</div>

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    function initQuill() {
        if (!document.getElementById('quill-editor')) return;
        
        // Prevent re-initialization
        if (document.querySelector('.ql-toolbar')) return;

        var quill = new Quill('#quill-editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'color': [] }, { 'background': [] }],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            }
        });

        var form = document.getElementById('cms-edit-form');
        if (form) {
            form.onsubmit = function() {
                var bodyInput = document.querySelector('#body-input');
                var content = quill.root.innerHTML;
                if(quill.getText().trim().length === 0 && !content.includes('<img')) {
                    bodyInput.value = '';
                } else {
                    bodyInput.value = content;
                }
            };
        }
        
        const toolbar = document.querySelector('.ql-toolbar');
        if(toolbar) {
            toolbar.style.border = 'none';
            toolbar.style.borderBottom = '1px solid #e2e8f0';
            toolbar.style.backgroundColor = '#f8fafc';
            toolbar.style.borderTopLeftRadius = '0.75rem';
            toolbar.style.borderTopRightRadius = '0.75rem';
        }
    }

    document.addEventListener('DOMContentLoaded', initQuill);
    document.addEventListener('turbo:load', initQuill);
</script>
</x-admin-layout>
