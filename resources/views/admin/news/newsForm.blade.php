@extends('starter-kit::layouts.adminlayout')

@section('content')
    <div class="container">

        <h1>
            @if(!isset($news))
                {{__('New News')}}
            @else
                {{__('Edit News')}}: {{$news->title}}
            @endif
        </h1>
        @include('starter-kit::component.err')

        <form enctype="multipart/form-data" class="row" method="post"
              @if(!isset($news)) action="{{route('admin.news.store')}}"
              @else  action="{{route('admin.news.update',$news->slug)}}" @endif>
            <div class="col-xl-9">
                <div class="card ">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="title">
                                        {{__('Title')}}
                                    </label>
                                    <input name="title" type="text"
                                           class="form-control @error('title') is-invalid @enderror"
                                           placeholder="{{__('Title')}}" value="{{old('title',$news->title??null)}}"/>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="subtitle">
                                        {{__('Subtitle')}}
                                    </label>
                                    <textarea name="subtitle"
                                              class="form-control @error('subtitle') is-invalid @enderror"
                                              placeholder="{{__('Subtitle')}}"
                                              rows="4">{{old('subtitle',$news->subtitle??null)}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="body">
                                        {{__('News Text')}}
                                    </label>
                                    <textarea name="body" class="form-control @error('body') is-invalid @enderror"
                                              placeholder="{{__('News Text')}}"
                                              rows="8">{{old('body',$news->body??null)}}</textarea>
                                    {{--                                    @trix(\App\News::class, 'body')--}}


                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="category_id">
                                        {{__('Main category')}}
                                    </label>
                                    <select name="category_id" data-live-search="true" id="category_id"
                                            class="form-control searchable  @error('category_id') is-invalid @enderror">
                                        @foreach($cats as $cat )
                                            <option value="{{ $cat->id }}"
                                                    @if (old('category_id',$news->category_id??null) == $cat->id ) selected @endif > {{$cat->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="image">
                                        {{__('Index image')}}
                                    </label>

                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="image"
                                               accept="image/*">
                                        <label class="custom-file-label"
                                               for="customFile"> {{__("Choose a image to upload")}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="status">
                                        {{__('Status')}}
                                    </label>
                                    <select name="status" id="status"
                                            class="form-control @error('status') is-invalid @enderror">
                                        <option value="1"
                                                @if (old('status',$news->status??null) == '1' ) selected @endif >{{__("Published")}} </option>
                                        <option value="0"
                                                @if (old('status',$news->status??null) == '0' ) selected @endif >{{__("Draft")}} </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 mt-3">
                                <div class="form-group mt-3">
                                    <br>
                                    <label for="is_breaking">
                                        {{__('Is breaking news?')}}
                                    </label>
                                    <input name="is_breaking" type="checkbox" id="is_breaking"

                                           class="float-left ml-4 mt-1 form-check-inline @error('is_breaking') is-invalid @enderror"
                                           placeholder="{{__('Is breaking news?')}}"
                                           @if (old('is_breaking',$news->is_breaking??0) != 0)
                                           checked
                                           @endif
                                           value="1"/>
                                </div>
                            </div>
                            <div class="col-md-3 mt-3">
                                <div class="form-group mt-3">
                                    <br>
                                    <label for="is_pinned">
                                        {{__('Pin')}}
                                    </label>
                                    <input name="is_pinned" type="checkbox" id="is_pinned"
                                           class="float-left ml-4 mt-1 form-check-inline @error('is_pinned') is-invalid @enderror"
                                           placeholder="{{__('Is pinned news?')}}"
                                           @if (old('is_pinned',$news->is_pinned??0) != 0)
                                           checked
                                            @endif/>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-3">
                @if (isset($news))
                    <div class="card mb-3">
                        <div class="card-header">
                            {{__("Index image")}}
                        </div>
                        <div class="card-body">
                            <img src="{{$news->imgurl()}}" class="img-fluid" alt="{{$news->title}}">
                        </div>
                    </div>
                @endif
                <div class="card mb-3">
                    <div class="card-header">
                        {{__("Categories")}}
                    </div>
                    <div class="card-body">
                        <ul class="category-control">
                            {!!\Xmen\StarterKit\Helpers\showCatNestedControl($cats,old('cat',isset($news)?$news->categories()->pluck('id')->toArray():[]))!!}
                        </ul>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        {{__("Tags")}}
                    </div>
                    <div class="card-body">
                        <input type="text" name="tags" class="taggble" @if(isset($news))
                        value="{{implode(',',$news->tag_names)}}"
                                @endif>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        {{__("Icon")}}
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="icon" id="icon" value="{{old('icon',$news->icon??null)}}"/>
                        <div class="btn-group btn-block">
                            <button type="button" class="btn btn-primary  iconpicker-component"><i
                                        class=" fa-fw {{$news->icon??''}}"></i></button>
                            <button type="button" data-src="#icon" class="icp icp-dd btn  btn-primary dropdown-toggle"
                                    data-selected="fa-car" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu"></div>
                        </div>

                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        {{__("Actions")}}
                    </div>
                    <div class="card-body">
                        <button type="submit" class="btn btn-block btn-primary">
                            <i class="fa fa-save"></i>
                            {{__("Save")}}
                        </button>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection
