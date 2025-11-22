@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
@if (session('message'))
<div class="todo__alert">
    <div class="todo__alert--success">
        {{ session('message') }}
    </div>
</div>
@endif
@if ($errors->any())
<div class="todo__alert-error">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="todo__content">
    <form class="create-form" action="/todos" method="post">
        @csrf
        <div class="create-form__item">
            <h2>新規作成</h2>
            <input class="create-form__item-input" type="text" name="content">
            <select class="create-form__item-category" name="category_id">
                <option value="" disabled selected hidden>カテゴリ</option>
                @foreach ($categories as $category)
                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="create-form__button">
            <button class="create-form__button-submit" type="submit">作成</button>
        </div>
    </form>
    <form class="search-form" action="todos/search" method="get">
        <div class="search-form__item">
            <h2 class="search-form__title">Todo検索</h2>
            <input class="search-form__item-input" type="text" name="content">
            <select class="create-form__item-category" name="category_id">
                <option value="" disabled selected hidden>カテゴリ</option>
                @foreach($categories as $category)
                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="search-form__button">
            <button class="create-form__button-submit" type="submit">検索</button>
        </div>
    </form>
    <div class="todo-table">
        <table class="todo-table__inner">
            <tr class="todo-table__row">
                <th class="todo-table__header">Todo</th>
                <th class="todo-table__header">カテゴリ</th>
            </tr>
            @foreach ($todos as $todo)
            <tr class="todo-table__row">
                <td class="todo-table__item">
                    <form class="update-form" action="/todos/update" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="update-form__item">
                            <input class="update-form__item-input" type="text" name="content" value="{{ $todo['content'] }}">
                            <input type="hidden" name="id" value="{{ $todo['id'] }}">
                        </div>
                        <div class="update-form__item">
                            <p class="update-form__item-p">{{ $todo['category']['name'] }}</p>
                        </div>
                        <div class="update-form__button">
                            <button class="update-form__button-submit" type="submit">更新</button>
                        </div>
                    </form>
                </td>
                <td class="todo-table__item">
                    <form class="delete-form" action="/todos/delete" method="post">
                        @csrf
                        @method('DELETE')
                        <div class="delete-form__button">
                            <input type="hidden" name="id" value="{{ $todo['id'] }}">
                            <button class="delete-form__button-submit" type="submit">削除</button>
                        </div>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    @endsection