<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      投稿詳細
    </h2>
  </x-slot>
  <div class="bg-white w-full rounded-2xl">
    <div class="mt-4 p-4">
      <h1 class="text-lg font-semibold">
        {{ $post->title }}
      </h1>
      <div class="text-right">
        <a href="{{ route('post.edit', $post) }}">
          <x-primary-button>
            編集
          </x-primary-button>
        </a>
        <form method="post" action="{{ route('post.destroy', $post) }}" class="flex-2">
          @csrf
          @method('delete')
          <x-primary-button class="ml-2 bg-red-700">
            削除
          </x-primary-button>
        </form>
      </div>
      <hr class="w-full">
      <p class="mt-4 whitespace-pre-line">
        {{ $post->body }}
      </p>
      <div class="txt-sm font-semibold flex flex-row-reverse">
        <p>{{ $post->created_at }}</p>
      </div>
    </div>
  </div>
  <script>
    // deleteボタンを押したときの確認ダイアログ
    document.addEventListener('DOMContentLoaded', function() {
      const deleteButton = document.querySelector('form button[type="submit"]');
      deleteButton.addEventListener('click', function(event) {
        const confirmed = confirm('本当に削除しますか？');
        if (!confirmed) {
          event.preventDefault();
        }
      });
    });
  </script>
</x-app-layout>
