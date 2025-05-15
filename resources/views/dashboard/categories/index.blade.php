<x-layouts.app :title="__('Dashboard')">
    <flux:heading>Product Categories</flux:heading>
    <flux:text class="mt-2">Informasi tentang data product categories.</flux:text>

    <flux:button href="{{ route('categories.create') }}" icon="plus" class="mt-4 mb-4">
        Add New Product Category
    </flux:button>

    @if(session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($categories as $key => $category)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $key + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <img 
                                src="{{ Storage::url($category->image) }}" 
                                alt="{{ $category->name }}" 
                                class="h-10 w-10 rounded-full">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->slug }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <flux:button 
                                href="{{ route('categories.edit', $category->id) }}" 
                                icon="pencil" 
                                variant="primary"
                                size="sm">
                                Edit
                            </flux:button>

                            <flux:button 
                                href="{{ route('categories.destroy', $category->id) }}" 
                                icon="trash" 
                                variant="danger"
                                size="sm"
                                onclick="event.preventDefault(); document.getElementById('delete-form-{{ $category->id }}').submit();">
                                Delete
                            </flux:button>
                            <form 
                                id="delete-form-{{ $category->id }}" 
                                action="{{ route('categories.destroy', $category->id) }}" 
                                method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-layouts.app>