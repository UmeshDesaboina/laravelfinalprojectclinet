@extends('layouts.admin')

@section('title', 'Review Management')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
    <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
        <h4 class="text-lg font-bold text-gray-800 dark:text-white">Product Reviews</h4>
        <a href="{{ route('admin.reviews.pending') }}" class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg font-semibold text-sm hover:bg-yellow-200 transition-colors">
            Pending Reviews
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-sm font-medium text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">
                    <th class="py-4 px-6">Product</th>
                    <th class="py-4 px-6">Customer</th>
                    <th class="py-4 px-6">Rating</th>
                    <th class="py-4 px-6">Comment</th>
                    <th class="py-4 px-6">Status</th>
                    <th class="py-4 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($reviews as $review)
                    <tr class="text-sm text-gray-700 dark:text-gray-300">
                        <td class="py-4 px-6">
                            <a href="{{ route('products.show', $review->product->slug) }}" class="font-medium hover:text-green-500">
                                {{ Str::limit($review->product->name, 30) }}
                            </a>
                        </td>
                        <td class="py-4 px-6">{{ $review->user->name }}</td>
                        <td class="py-4 px-6">
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endfor
                            </div>
                        </td>
                        <td class="py-4 px-6 max-w-xs truncate">{{ Str::limit($review->comment, 50) }}</td>
                        <td class="py-4 px-6">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $review->is_approved ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $review->is_approved ? 'Approved' : 'Pending' }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right space-x-2">
                            @if(!$review->is_approved)
                                <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="text-green-500 hover:text-green-700 font-semibold text-sm">Approve</button>
                                </form>
                            @else
                                <form action="{{ route('admin.reviews.reject', $review) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="text-yellow-500 hover:text-yellow-700 font-semibold text-sm">Reject</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this review?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold text-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="p-6">
        {{ $reviews->links() }}
    </div>
</div>
@endsection
