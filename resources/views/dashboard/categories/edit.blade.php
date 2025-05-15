<x-layouts.app :title="__('Create new Product Category')">
    <flux:heading>Edit Product Category</flux:heading>
    <flux:subheading>Form untuk mengupdate data product category baru.</flux:subheading>
    <flux:separator variant="subtle"/>

    <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @method('patch')
        @csrf
        <!-- 
            Field Product Category: name, slug, description, image
        -->
        <flux:input name="name" label="Name" value="{{ $category->name }}" placeholder="Product Category Name" required/>

        <flux:input name="slug" label="Slug" value="{{ $category->slug }}" placeholder="product-category-name" required/>

        <flux:textarea name="description" label="Description" placeholder="Product Description" required>
            {{ $category->description }}
        </flux:textarea>

        @if($category->image)
            <div class="mb-4">
                <img 
                    src="{{ Storage::url($category->image) }}" 
                    alt="{{ $category->name }}" 
                    class="h-10 w-10 rounded-full">
            </div>
        @endif

        <flux:input name="image" type="file" label="Image" placeholder="Product Image"/>

        <flux:button type="submit" icon="plus" variant="primary" class="mt-4">
            Simpan
        </flux:button>
    </form>
</x-layouts.app>