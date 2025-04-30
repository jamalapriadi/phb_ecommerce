<x-layouts.app :title="__('Posts')">
    <h1>Posts</h1>

    <!-- untuk menampilkan pesan sukses -->
    @if(session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session()->get('success') }}
        </div>
    @endif

    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-300 px-4 py-2 text-left">Title</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Content</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Created At</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Updated At</th>
            </tr>
        </thead>
        <tbody>
            <!-- untuk menampilkan data post -->
            @foreach($posts as $key=>$post)
                <tr class="{{ $key % 2 === 0 ? 'bg-white' : 'bg-gray-100' }}">
                    <td class="border border-gray-300 px-4 py-2">{{ $post->title }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $post->content }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $post->created_at }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $post->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layouts.app>