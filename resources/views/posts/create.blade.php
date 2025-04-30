<x-layouts.app :title="__('Create New Post')">
    <!-- membuat form -->
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf 
        <flux:input 
            label="Title" 
            name="title" 
            type="text" 
            class="mb-3"
            placeholder="Enter post title" required />

        <flux:input 
            label="Slug" 
            name="slug" 
            type="text" 
            class="mb-3"
            placeholder="Enter post slug" required />

        <flux:textarea 
            label="Content" 
            name="content" 
            type="textarea" 
            class="mb-3"
            placeholder="Enter post content" required />

        <flux:input 
            label="Image" 
            name="image" 
            class="mb-3"
            type="file" accept="image/*" />

        <flux:button type="submit" variant="primary">
            Save
        </flux:button>
    </form>
</x-layouts.app>