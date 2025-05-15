<x-layouts.app :title="__('Create new Product Category')">
    <flux:heading>Create new Product Category</flux:heading>
    <flux:subheading>Form untuk menambah data product category baru.</flux:subheading>
    <flux:separator variant="subtle"/>

    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- 
            Field Product Category: name, slug, description, image
        -->
        <flux:input name="name" label="Name" placeholder="Product Category Name" required/>

        <flux:input name="slug" label="Slug" placeholder="product-category-name" required/>

        <flux:textarea name="description" label="Description" placeholder="Product Description" required/>

        <flux:input name="image" type="file" label="Image" placeholder="Product Image"/>

        <flux:button type="submit" icon="plus" variant="primary" class="mt-4">
            Simpan
        </flux:button>
    </form>
</x-layouts.app>