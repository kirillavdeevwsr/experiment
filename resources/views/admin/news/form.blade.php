@extends('layouts.admin')
@section ('content')
    <div class="center-block">
        @if (session('mes'))
            <div class="container"><p class="text-danger" style="font-size: 35px">{{ session ('mes')}}</p></div>
        @endif
        @if (isset($news))
            <h1>Редактирование статьи: {{$news->title}} </h1>
        @else
            <h1>Создание новости</h1>
            <p class="text-danger">Заполните все поля!</p>
        @endif
            <div id="form_news">
        <form method='post'
              action="@if (isset($news)) {{route ('news.update', $news->id)}} @else {{route ('news.store')}} @endif"
              class="form center-block" id="news_form"
        enctype="multipart/form-data">
            {{csrf_field()}}

                {{method_field("POST")}}

            <fieldset class="form-group">
                <label for="title">Заголовок:</label>
                <p style="font-size: 12px" class="text-danger">Не больше 95 символов!</p>
                <input required maxlength= "95" class="form-control" name="title" id="title" type="text"
                       value="{{isset ($news) ? $news->title: ''}}">
            </fieldset>
            @if (isset($news))
                <img style = 'width: 50%' src="{{$news->img}}" alt="">
                <p class="text-danger">Изменить картинку:</p>
            @endif
            <fieldset class="form-group">
                <label for="img">Ссылка на изображение для отображения на главной странице:</label>
                <input class="form-control"   id="img" name="img" type="text" value="{{isset ($news) ? $news->img: ''}}">
            </fieldset>
            <fieldset class="form-group" >
                <label for="file_img">Или сохраните картинку на сайте </label>
                <br>
                <span class="btn btn-default btn-file text-dark">
                    <input multiple="multiple"  id = 'file_img' name = 'file_img' type="file" >
                    </span>
            </fieldset>
            <fieldset class="form-group"><label for="preview">Краткое описание:</label>
                <p style="font-size: 12px" class="text-danger">Не больще 430 символов!</p>
                <textarea required maxlength="430"  class="form-control" id="preview" rows="10"
                          name="preview">{{isset ($news) ? $news->preview: ''}}</textarea>
            </fieldset>
            <fieldset class="form-group">
                <label for="text">Текст:</label>
                <textarea id="text" name="text" class="form-control">{{isset ($news) ? $news->text: ''}}</textarea>
            </fieldset>

            <br><br>
        </form>
            </div>
    </div>
    <div class="container file-append">
        <p>Прикрепленные файлы:</p>
        <table class="table">
    @if (isset($files))
        @foreach($files as $file)
        <tr id="{{$file->id}}" >
            <td>
            <a href="{{$file->link}}">{{$file->alt}}"</a></td>
            <td><p>{{$file->type}}</p></td>
            <td><form class="del_file" method="post" action="{{route('delete_file', $file->id)}}" >
                    {{csrf_field()}}
                    {{method_field ('POST')}}
                    <input type="hidden" value="{{$file->id}}">
                    <input type="submit"  class=" btn btn-danger" value="Удалить"></form>
            </td>
        </tr>
        @endforeach
            @endif
</table>
    </div>
        <hr>
        <br>


    <div class="container">
        <div class="row add ">
            <a href="#" data-content="video">
                <button class="btn btn-success">Добавить видео</button>
            </a>
            <a href="#" data-content="image">
                <button class="btn btn-warning">Добавить изображение</button>
            </a>
            <a href="#" data-content="document">
                <button class="btn btn-info">Добавить документ</button>
            </a>
        </div>
    </div>
    <br>
    <br>
    <div class="links">
        <div id="image">
                <fieldset class="form-group">
                    <label for="">Ссылка на изображение:</label>
                    <input class="form-control" id='link' name="link" type="text">
                </fieldset>
            <fieldset class="form-group" >
                <label for="add_img">Или сохраните картинку на сайте </label>
                <br>
                <span class="btn btn-default btn-file text-dark">
                        <input multiple="multiple" form="news_form" id = 'add_img' name = 'add_img' type="file" >
                        </span>
            </fieldset>

                <fieldset class="form-group">
                    <label for="">Название:</label>
                    <input class="form-control" id='alt' name="alt" type="text">
                </fieldset>
            <button class='next-link btn btn-dark' id = 'add_file' type="submit" value= >Добавить изображение</button>
            </div>
            <div id="video">
                <p>Для отображения видео, оно должно быть скопированно с <a href="https://www.youtube.com/">YouTube</a>.</p>
                <p>Нажмите правой кнопкой мыши на видео, выберите пункт "Копировать HTML-код".</p>
                <fieldset class="form-group">
                    <label for="">Ссылка на видео:</label>
                    <input class="form-control" id='link' name="link" type="text">
                </fieldset>
                <fieldset class="form-group">
                    <label for="">Название:</label>
                    <input class="form-control" id='alt' name="alt" type="text">
                </fieldset>
                <button class='next-link btn btn-dark' type="submit" value="">Добавить ссылку</button>
            </div>
            <div id="document">
                <fieldset class="form-group">
                    <label for="">Ссылка на документ:</label>
                    <input class="form-control" id='link' name="link" type="text">
                </fieldset>
                <fieldset class="form-group">
                    <label for="">Название:</label>
                    <input class="form-control" id='alt' name="alt" type="text">
                </fieldset>
                <button class='next-link btn btn-dark' type="submit" >Добавить ссылку</button>
            </div>
    </div>
    <div class="row form_button">
        @if (isset($news))
            <input form='news_form' type="submit" class="btn btn-success" value="Изменить новость">
            <form action="{{route('news.destroy', $news->id)}}" class = 'del_file2' method="post">
                {{  csrf_field()}}
                {{ method_field ('DELETE') }}
                <input type="submit" class="btn btn-danger" value="Удалить">
            </form>
        @else
            <input form='news_form' type="submit" class="btn btn-success" value="Сохранить новость">
        @endif
    </div>
    <script>
        $(document).ready(function () {
        tinymce.init({
        selector: '#text',
        height: 500,
        theme: 'modern',
            language:'ru',
        toolbar: 'code',
        plugins: 'code preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools  contextmenu colorpicker textpattern help',
        toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat | code',
        });
        });
    </script>
    <script defer>
        $(document).ready(function () {
            var files1=[];
            var saveImages =[];
            function saveFileArray(th) {
                var file = {};
                var typeLink = $(th).parent().attr('id');
                file['type'] = typeLink;
                $(th).parent().find('fieldset input').each(function (i, e) {
                    if(e.value){
                        file[(e.id)] = e.value;
                        $(e).val('');
                    }
                });
                if (file['link'] && file['alt']){
                    files1.push(file);
                    $(th).parent().hide();
                    var html = '<tr><td><a href ="' + file['link'] + '">' + file['alt'] + '</a></td><td><p>' +
                        typeLink + '</p></td><td><button class="del_link btn btn-danger " data-index="' + files1.indexOf(file) +
                        '">Удалить</button></td></tr><br>';
                    $('.file-append .table').append(html);
                }
            };

            $('.links div').hide();
            $('.add a').on('click', (function (event) {
                event.preventDefault();
                var data = this.dataset.content;
                var elem = document.getElementById(data);
                $(elem).toggle();
            }));
            var img_file;
            $('#file_img').change(function(){
                img_file = this.img_file;
            });
            var add_img;
            $('#add_img').change(function() {
                add_img = this.add_img;
            });

            @if (isset($news))
                var newsId ={{$news->id}};
                    @else
            var newsId=0;
            @endif

            $('.next-link').on('click', function(e) {
                if ($(this).attr('id') == 'add_file') {
                    if ($(this).parent().find('#link').val()) {
                        saveFileArray(this);
                    } else {
                        var data = new FormData(document.forms.news_form);
                        $.each(add_img, function (key, value) {
                            data.append(key, value);
                        });
                        data.append('newsId', newsId);
                        console.log(newsId);

                        $.ajax({
                            dataType: 'json',
                            type: 'post',
                            url: '/admin/add_img',
                            data: data,
                            cache: false,
                            processData: false,
                            contentType: false,
                            _token: $('#news_form').find("[name=_token]").val(),
                            error: function (error) {
                                console.log(error);
                            }
                        }).done(function (response) {
                                if (response) {
                                    var res = response;
                                    // console.log(res);
                                    newsId = res.news_id;
                                    // console.log(newsId)
                                    $(this).parent().hide();
                                    var html = '<tr id="'+res.file_id+'"><td><a href="#">'+res.file_name+
                                        '</a></td><td><p>image</p></td><td><form class ="del_file" method = "post" action="/admin/deletefile/'
                                        + res.file_id+ '">{{csrf_field()}}{{method_field ('POST')}}<input type="hidden" value="'
                                        + res.file_id+'">'
                                        + '<input type="submit"  class=" btn btn-danger" value="Удалить"></form></td></tr><br>';
                                    $('.file-append .table').append(html);
                                    saveImages.push(res);
                                };
                            }.bind(this)
                        );
                    }
                } else {
                    saveFileArray(this);
                }
            });

            $('body').on('click', '.del_link',  function(e){
                e.preventDefault();
                var index=this.dataset.index;
                delete files1[index];
                $(this).parent().parent().remove();
            });

            $('#news_form').on('submit', function(event){
                event.stopPropagation();
                event.preventDefault();
                var redirect = '/admin/news/';
                // var data=$(this).serializeArray();
                var data = new FormData(this);
                $.each(img_file, function( key, value ){
                    data.append( key, value );
                });
                data.append( 'files',  JSON.stringify(files1));
                data.append( 'saveImages',  JSON.stringify(saveImages));

                $.ajax({
                    dataType: 'json',
                    type : 'post',
                    url : $(this).attr('action'),
                    data : data ,
                    cache: false,
                    processData: false,
                    contentType: false,
                    _token : $(this).find("[name=_token]").val(),
                    error:function(error){
                        console.log(error);
                    }
                }).done(function(response){
                        if (response){
                            window.location = redirect + response;
                        };
                    }.bind(this)
            );
                return false;


            });

            $('body').on('submit', '.del_file',  function(e){
                e.preventDefault();
                e.stopPropagation();
                $.ajax({
                    url: $(this).attr('action'),
                    method : $(this).find("[name=_method]").val(),
                    _token : $(this).find("[name=_token]").val(),
                    data: $(this).serializeArray(),
                    error:function(error){
                        console.log(error);
                    }
                }).done(function(response){
                        if (response){
                            // console.log(response);
                            document.getElementById(response).remove();
                        };
                    }.bind(this)
                );
                return false;

                });

        });
    </script>



@endsection