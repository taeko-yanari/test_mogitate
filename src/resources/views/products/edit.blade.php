@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endsection

@section('content')
<div class="product-edit">
  <section class="product-edit__section">

    {{-- パンくずリスト --}}
    <nav aria-label="パンくずリスト">
      <ol class="breadcrumb">
        <li class="breadcrumb__item"><a href="/products">商品一覧</a></li>
        <li class="breadcrumb__item" aria-current="page">{{ $product->name }}</li>
      </ol>
    </nav>

    <form action="{{ route('products.update', $product->id) }}" method="post"  id="product-update-form" class="product-edit__form" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="product-edit__flex">
        <div class="product-edit__left">

          {{-- 画像 --}}
          <div class="product-edit__image-area">
            <div class="product-edit__image-wrap">
              <img id="preview-image" src="{{ session('temp_image_path') ? Storage::url(session('temp_image_path')) : ($product->image ? Storage::url($product->image) : asset('images/no-image.png')) }}" alt="{{ $product->name }}">
            </div>

            <div class="product-edit__file">
              <label for="image" class="product-edit__file-btn">ファイルを選択</label>
              <span class="product-edit__file-name" id="file-name-display">
                {{ session('temp_image_name') ?? ($product->image ? basename($product->image) : '選択されていません') }}
              </span>
              <input type="file" id="image" name="image" style="display: none;">
            </div>

            @if ($errors->has('image'))
            <ul class="error-messages">
              @foreach ($errors->get('image') as $message)
              <li>{{ $message }}</li>
              @endforeach
            </ul>
            @endif
          </div>
        </div>

        <div class="product-edit__right">

          {{-- 商品名 --}}
          <div class="edit-form__field">
            <label for="name" class="edit-form__label">商品名</label>
            <input type="text" name="name" id="name" autocomplete="name" class="edit-form__input" value="{{ old('name', $product->name) }}">

            @if ($errors->has('name'))
            <ul class="error-messages">
              @foreach ($errors->get('name') as $message)
              <li>{{ $message }}</li>
              @endforeach
            </ul>
            @endif
          </div>
 
          {{-- 値段 --}}
          <div class="edit-form__field">
            <label for="price" class="edit-form__label">値段</label>
            <input type="text" name="price" id="price" autocomplete="price" class="edit-form__input" value="{{ old('price', $product->price) }}">

            @if ($errors->has('price'))
            <ul class="error-messages">
              @foreach ($errors->get('price') as $message)
              <li>{{ $message }}</li>
              @endforeach
            </ul>
            @endif
          </div>

          {{-- 季節 --}}
          <div class="edit-form__field">
            <p class="edit-form__label">季節</p>
            <div class="edit-form__checkbox">
              @foreach ($seasons as $season)
              <label for="season_{{ $season->id }}" class="edit-form__checkbox-label">
                <input type="checkbox" name="season_ids[]" id="season_{{ $season->id }}" value="{{ $season->id }}" class="edit-form__checkbox-input" {{ in_array((string)$season->id, array_map('strval', old('season_ids', $product->seasons->pluck('id')->toArray()))) ? 'checked' : '' }}><span class="check-mark"></span>{{ $season->name }}
              </label>
              @endforeach
            </div>
            @if ($errors->has('season_ids'))
            <ul class="error-messages">
              @foreach ($errors->get('season_ids') as $message)
              <li>{{ $message }}</li>
              @endforeach
            </ul>
            @endif
          </div>
        </div>
      </div>

      {{-- 商品説明 --}}
      <div class="edit-form__field edit-form__textarea-group">
        <label for="description" class="edit-form__label">商品説明</label>
        <textarea placeholder="商品の説明を入力" name="description" id="description" cols="40" rows="10" class="edit-form__textarea">{{ old('description', $product->description) }}</textarea>

        @if ($errors->has('description'))
        <ul class="error-messages">
          @foreach ($errors->get('description') as $message)
          <li>{{ $message }}</li>
          @endforeach
        </ul>
        @endif
      </div>
    </form>

    {{-- 戻る・変更ボタン --}}
    <div class="edit-form__button">
      <div class="edit-form__button-wrapper">
          <a href="{{ route('products.index') }}" class="edit-form__back-link">戻る</a>
          <button type="submit" class="edit-form__submit"  form="product-update-form">変更を保存</button>
      </div>
      {{-- 削除アイコン --}}
      <div class="edit-form__delete-icon">
        <form action="{{ route('products.destroy', $product->id) }}" method="post">
          @csrf
          @method('DELETE')
          <button type="submit" class="edit-form__trash-icon">
            <i class="fa-regular fa-trash-can" style="color: hsl(2, 98%, 51%);"></i>
          </button>
        </form>
      </div>
    </div>
  </section>
</div>
@endsection

@section('js')
<script src="{{ asset('js/image-preview-edit.js') }}"></script>
 @endsection


