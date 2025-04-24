<x-layouts.app :title="__('Dashboard')">
    <flux:heading>Product Categories</flux:heading>
    <flux:text class="mt-2">Informasi tentang data product categories.</flux:text>

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
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->slug }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-layouts.app>