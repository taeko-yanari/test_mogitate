@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="product-register">
  <section class="product-register__section">
    <h1 class="page-title">商品登録</h1>
    <form action="{{ route('products.store') }}" method="post" class="product-register__form" enctype="multipart/form-data">
      @csrf
      <div class="product-register__flex">
        {{-- 商品名 --}}
        <div class="register-form__field">
          <label for="name" class="register-form__label">商品名<span class="required">必須</span></label>
          <input type="text" placeholder="商品名を入力" name="name" id="name" autocomplete="name" class="register-form__input" value="{{ old('name') }}">

          @if ($errors->has('name'))
          <ul class="error-messages">
            @foreach ($errors->get('name') as $message)
            <li>{{ $message }}</li>
            @endforeach
          </ul>
          @endif
        </div>

        {{-- 値段 --}}
        <div class="register-form__field">
          <label for="price" class="register-form__label">値段<span class="required">必須</span></label>
          <input type="text" placeholder="値段を入力" name="price" id="price" autocomplete="price" class="register-form__input" value="{{ old('price') }}">

          @if ($errors->has('price'))
          <ul class="error-messages">
            @foreach ($errors->get('price') as $message)
            <li>{{ $message }}</li>
            @endforeach
          </ul>
          @endif
        </div>

        {{-- 商品画像 --}}
        <div class="register-form__field">
          <label for="image" class="register-form__label">商品画像<span class="required">必須</span></label>
          <input type="file" name="image" id="image" class="product-register__file-input">

          <div id="preview-area" class="product-register__image-wrap" style="{{ session('temp_image_path') ? 'display:block;' : 'display:none;' }}">
            <img id="preview-image" class="product-register__image" alt="" src="{{ session('temp_image_path') ? asset('storage/' . session('temp_image_path')) : '' }}">
          </div>

          <div class="product-register__file">
            <label for="image" class="product-register__file-btn">ファイルを選択</label>
            <p id="preview-name" class="product-register__file-name">{{ session('temp_image_name') ?? '' }}</p>
          </div>

          <input type="hidden" name="temp_image" id="temp_image" value="{{ old('temp_image') }}">

          @if ($errors->has('image'))
          <ul class="error-messages">
            @foreach ($errors->get('image') as $message)
            <li>{{ $message }}</li>
            @endforeach
          </ul>
          @endif
        </div>

        {{-- 季節 --}}
        <div class="register-form__field">
          <p class="register-form__label">季節<span class="required">必須</span><span class="product-create__note">複数選択可</span></p>
          <div class="register-form__checkbox">
            @foreach($seasons as $season)
            <label for="season_{{ $season->id }}" class="register-form__checkbox-label">
              <input type="checkbox" name="season_ids[]" id="season_{{ $season->id }}" value="{{ $season->id }}" class="register-form__checkbox-input" {{ in_array($season->id, old('season_ids', [])) ? 'checked' : '' }}>
              <span class="check-mark"></span>{{ $season->name }}
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

        {{-- 商品説明 --}}
        <div class="register-form__field">
          <label for="description" class="register-form__label">商品説明<span class="required">必須</span></label>
          <textarea placeholder="商品の説明を入力" name="description" id="description" cols="40" rows="10" class="register-form__textarea">{{ old('description') }}</textarea>

          @if ($errors->has('description'))
          <ul class="error-messages">
            @foreach ($errors->get('description') as $message)
            <li>{{ $message }}</li>
            @endforeach
          </ul>
          @endif
        </div>
      </div>

      {{-- ボタン --}}
      <div class="register-form__button">
        <a href="{{ route('products.index') }}" class="register-form__back-link">戻る</a>
        <button type="submit" class="register-form__submit">登録</button>
      </div>
    </form>
  </section>
</div>
@endsection

@section('js')
<script src="{{ asset('js/image-preview.js') }}"></script>
@endsection