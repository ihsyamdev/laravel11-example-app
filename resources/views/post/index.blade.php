<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      投稿一覧
    </h2>
  </x-slot>
  <div class="mx-auto px-6">
    {{-- @if (session('message'))
      <div class="text-red-600 font-bold">
        {{ session('message') }}
      </div>
    @endif --}}
    <x-message :message="session('message')" />
    {{-- 検索バー --}}
    <div class="w-5/6 m-auto mb-5 mt-5">
      <form method="get" action="{{ route('post.index') }}" class="flex">
        <input type="text" name="search" placeholder="検索ワードを入力" value="{{ request('search') }}"
          class="w-5/6 p-2 rounded-2xl">
        <button type="submit" class="p-2 bg-blue-500 text-white rounded-xl w-1/6 ml-2 font-bold">
          検索
        </button>
      </form>
    </div>
    {{-- ソートボタン --}}
    @if (request('sort') === 'title')
      <x-primary-button>
        <a href="{{ route('post.index', ['sort' => 'title', 'search' => request('search')]) }}">件名でソート</a>
      </x-primary-button>
      <x-secondary-button>
        <a href="{{ route('post.index', ['sort' => 'created_at', 'search' => request('search')]) }}">作成日でソート</a>
      </x-secondary-button>
    @elseif (request('sort') === 'created_at')
      <x-secondary-button>
        <a href="{{ route('post.index', ['sort' => 'title', 'search' => request('search')]) }}">件名でソート</a>
      </x-secondary-button>
      <x-primary-button>
        <a href="{{ route('post.index', ['sort' => 'created_at', 'search' => request('search')]) }}">作成日でソート</a>
      </x-primary-button>
    @else
      <x-secondary-button>
        <a href="{{ route('post.index', ['sort' => 'title', 'search' => request('search')]) }}">件名でソート</a>
      </x-secondary-button>
      <x-secondary-button>
        <a href="{{ route('post.index', ['sort' => 'created_at', 'search' => request('search')]) }}">作成日でソート</a>
      </x-secondary-button>
    @endif
    {{-- データの表示 --}}
    @foreach ($posts as $post)
      <div class="mt-4 p-8 bg-white w-full rounded-2xl">
        <h1 class="p-4 text-lg font-semibold">
          件名:
          <a href="{{ route('post.show', $post) }}" class="text-blue-600">
            {{ $post->title }}
          </a>
        </h1>
        <hr class="w-full">
        <p class="mt-4 p-4">
          {{ $post->body }}
        </p>
        <div class="p-4 text-sm font-semibold">
          <p>
            {{ $post->created_at }} / {{ $post->user->name ?? '匿名' }}
          </p>
        </div>
      </div>
    @endforeach
    <div class="mb-4">
      {{ $posts->appends(request()->query())->links() }}
    </div>
  </div>
  <script>
    // searchパラメータがある場合、検索バーにフォーカスを当てる
    const search = '{{ request('search') }}';
    if (search) {
      document.querySelector('input[name="search"]').focus();
    }
  </script>
</x-app-layout>
