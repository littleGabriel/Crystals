@extends('layouts.app')

@section('content')
<div class="container-fluid mt-md-3">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 p-0">
            <nav aria-label="breadcrumb" style="opacity: 0.8">
                <ol class="breadcrumb mb-0 mb-md-3">
                    @php
                        $dirArr = explode('-',$dir);
                        $name = array();
                        $href = array();
                        foreach ($dirArr as $value) {
                            array_push($name,$value);
                            array_push($href,implode("-", $name));
                        }
                    @endphp
                    @empty($word)
                        @foreach ($dirArr as $name)
                            @if ($loop->last)
                                <li class="breadcrumb-item active" aria-current="page">{{$name}}</li>
                            @else
                                <li class="breadcrumb-item"><a href="/home/dir/{{$href[$loop->index]}}">{{$name}}</a></li>
                            @endif
                        @endforeach
                    @endempty
                    @isset($word)
                        <li class="breadcrumb-item">'{{$word}}' 搜索结果</li>
                    @endisset
                </ol>
            </nav>

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-0 mb-md-3 rounded-0" style="opacity: 0.8">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <div class="card p-md-2 shadow-sm rounded-0" style="opacity: 0.8">
                <div class="card-body pt-0">
                        @if($Users_files_count==0)
                            <div class="mt-2">&nbsp;</div>
                            <div class="alert alert-primary alert-dismissible fade show lead">
                                点击下方按钮上传文件~
                            </div>
                        @else
                            <table class="table table-hover">
                                <thead>
                                    <tr class="row table-borderless">
                                        <th scope="col" class="col-4 table-light">文件名</th>
                                        <th scope="col" class="col-4 table-light">上传时间</th>
                                        <th scope="col" class="col-3 table-light">大小</th>
                                        <th scope="col" class="col-1 table-light"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($Users_files as $file)
                                <tr class="row">
                                    @if($file -> file_size==0)
                                        <th scope="row" class="col-4">
                                            <svg width="1.4em" height="1.4em" viewBox="0 0 16 16" class="bi bi-folder mr-1 text-primary" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.828 4a3 3 0 0 1-2.12-.879l-.83-.828A1 1 0 0 0 6.173 2H2.5a1 1 0 0 0-1 .981L1.546 4h-1L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3v1z"/>
                                                <path fill-rule="evenodd" d="M13.81 4H2.19a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4zM2.19 3A2 2 0 0 0 .198 5.181l.637 7A2 2 0 0 0 2.826 14h10.348a2 2 0 0 0 1.991-1.819l.637-7A2 2 0 0 0 13.81 3H2.19z"/>
                                            </svg>
                                            <a href="/home/dir/{{$dir}}-{{$file -> file_name}}">{{$file -> file_name}}</a>
                                        </th>
                                        <td class="col-4"></td>
                                        <td class="col-3"></td>
                                        <td class="col-1">
                                            <div class="dropdown">
                                                <a href="#" data-toggle="dropdown" class="dropdownToggle">
                                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots-vertical" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                                    </svg>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="dropdownMenuButton">
                                                    <form class="dropdown-item m-0" method="post" action="/home/delete" onclick="this.submit();">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$file -> id}}" />
                                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-archive" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M2 5v7.5c0 .864.642 1.5 1.357 1.5h9.286c.715 0 1.357-.636 1.357-1.5V5h1v7.5c0 1.345-1.021 2.5-2.357 2.5H3.357C2.021 15 1 13.845 1 12.5V5h1z"/>
                                                            <path fill-rule="evenodd" d="M5.5 7.5A.5.5 0 0 1 6 7h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5zM15 2H1v2h14V2zM1 1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H1z"/>
                                                        </svg>
                                                        &nbsp;&nbsp;&nbsp;删除
                                                    </form>
                                                    <a class="dropdown-item" data-id="{{$file -> id}}" data-name="{{$file -> file_name}}" data-toggle="modal" data-target="#renameModal">
                                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                        </svg>
                                                        &nbsp;&nbsp;&nbsp;重命名
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    @else
                                        <th scope="row" class="col-4">
                                            <svg width="1.4em" height="1.4em" viewBox="0 0 16 16" class="bi bi-file-earmark mr-1" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4 1h5v1H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V6h1v7a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2z"/>
                                                <path d="M9 4.5V1l5 5h-3.5A1.5 1.5 0 0 1 9 4.5z"/>
                                            </svg>
                                            {{$file -> file_name}}
                                        </th>
                                        <td class="col-4">{{$file -> created_at -> format('Y-m-d H:i')}}</td>
                                        <td class="col-3">{{$file -> file_size}}</td>
                                        <td class="col-1">
                                            <div class="dropdown">
                                                <a href="#" data-toggle="dropdown" class="dropdownToggle">
                                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots-vertical" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                                    </svg>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="/home?dlPath={{$file -> file_url}}">
                                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M.5 8a.5.5 0 0 1 .5.5V12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8.5a.5.5 0 0 1 1 0V12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V8.5A.5.5 0 0 1 .5 8z"/>
                                                            <path fill-rule="evenodd" d="M5 7.5a.5.5 0 0 1 .707 0L8 9.793 10.293 7.5a.5.5 0 1 1 .707.707l-2.646 2.647a.5.5 0 0 1-.708 0L5 8.207A.5.5 0 0 1 5 7.5z"/>
                                                            <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0v-8A.5.5 0 0 1 8 1z"/>
                                                        </svg>
                                                        &nbsp;&nbsp;&nbsp;下载
                                                    </a>
                                                    <form class="dropdown-item m-0" method="post" action="/home/delete" onclick="this.submit();">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$file -> id}}" />
                                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-archive" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M2 5v7.5c0 .864.642 1.5 1.357 1.5h9.286c.715 0 1.357-.636 1.357-1.5V5h1v7.5c0 1.345-1.021 2.5-2.357 2.5H3.357C2.021 15 1 13.845 1 12.5V5h1z"/>
                                                            <path fill-rule="evenodd" d="M5.5 7.5A.5.5 0 0 1 6 7h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5zM15 2H1v2h14V2zM1 1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H1z"/>
                                                        </svg>
                                                        &nbsp;&nbsp;&nbsp;删除
                                                    </form>
                                                    <a class="dropdown-item m-0" data-toggle="modal" data-target="#moveModal" data-id="{{$file -> id}}">
                                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up-right-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                            <path fill-rule="evenodd" d="M10.5 5h-4a.5.5 0 0 0 0 1h2.793l-4.147 4.146a.5.5 0 0 0 .708.708L10 6.707V9.5a.5.5 0 0 0 1 0v-4a.5.5 0 0 0-.5-.5z"/>
                                                        </svg>
                                                        &nbsp;&nbsp;&nbsp;移动
                                                    </a>
                                                    <a class="dropdown-item" data-id="{{$file -> id}}" data-name="{{$file -> file_name}}" data-toggle="modal" data-target="#renameModal">
                                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                        </svg>
                                                        &nbsp;&nbsp;&nbsp;重命名
                                                    </a>
                                                    <form class="dropdown-item m-0" method="post" action="" id="Share" onclick="
                                                        const input = document.createElement('input');
                                                        document.body.appendChild(input);
                                                        input.setAttribute('value', '{{$_ENV['APP_URL']}}/home/share?path={{$file -> file_url}}');
                                                        input.select();
                                                        if (document.execCommand('copy')) {
                                                            document.execCommand('copy');
                                                            $('#myToast').toast('show');
                                                        }
                                                        document.body.removeChild(input);
                                                        $('.dropdownToggle').dropdown('hide');
                                                    ">
                                                        @csrf
                                                        <input type="hidden" name="path" value="{{$file -> file_url}}" />
                                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-share" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M11.724 3.947l-7 3.5-.448-.894 7-3.5.448.894zm-.448 9l-7-3.5.448-.894 7 3.5-.448.894z"/>
                                                            <path fill-rule="evenodd" d="M13.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm0 10a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm-11-6.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                                                        </svg>
                                                        &nbsp;&nbsp;&nbsp;复制链接
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    @endif

                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $Users_files->links() }}
                        @endif



                </div>
            </div>

            @empty($word)

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-outline-primary float-right mt-3 mr-3 mr-md-0" data-toggle="modal" data-target="#uploadModal">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-upload" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M.5 8a.5.5 0 0 1 .5.5V12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8.5a.5.5 0 0 1 1 0V12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V8.5A.5.5 0 0 1 .5 8zM5 4.854a.5.5 0 0 0 .707 0L8 2.56l2.293 2.293A.5.5 0 1 0 11 4.146L8.354 1.5a.5.5 0 0 0-.708 0L5 4.146a.5.5 0 0 0 0 .708z"/>
                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0v-8A.5.5 0 0 1 8 2z"/>
                </svg>
                上传文件
            </button>
            <button type="button" class="btn btn-outline-primary float-right mr-3 mt-3 ml-3 ml-md-0" data-toggle="modal" data-target="#folderPlusModal">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-folder-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M9.828 4H2.19a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91H9v1H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181L15.546 8H14.54l.265-2.91A1 1 0 0 0 13.81 4H9.828zm-2.95-1.707L7.587 3H2.19c-.24 0-.47.042-.684.12L1.5 2.98a1 1 0 0 1 1-.98h3.672a1 1 0 0 1 .707.293z"/>
                    <path fill-rule="evenodd" d="M13.5 10a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z"/>
                    <path fill-rule="evenodd" d="M13 12.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z"/>
                </svg>
                新建文件夹
            </button>
            @endempty
            @isset($word)
            <a href="/home" class="btn btn-outline-primary float-left mt-3 ml-3 ml-md-0">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-90deg-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M6.104 2.396a.5.5 0 0 1 0 .708L3.457 5.75l2.647 2.646a.5.5 0 1 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 0 1 .708 0z"/>
                    <path fill-rule="evenodd" d="M2.75 5.75a.5.5 0 0 1 .5-.5h6.5a2.5 2.5 0 0 1 2.5 2.5v5.5a.5.5 0 0 1-1 0v-5.5a1.5 1.5 0 0 0-1.5-1.5h-6.5a.5.5 0 0 1-.5-.5z"/>
                </svg>
                返回
            </a>
            @endisset
        </div>
    </div>
</div>

<!-- uploadModal -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">上传文件</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/home/upload" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="custom-file mb-3">
                        <input type="file" name="file[]" class="custom-file-input" id="customFile" multiple="multiple">
                        <label class="custom-file-label" for="customFile">选择文件</label>
                    </div>
                </div>
                <input type="hidden" name="dir" value="{{$dir}}"/>
                <div class="modal-footer">
                    <input type="submit" value="提交" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- renameModal -->
<div class="modal fade" id="renameModal" tabindex="-1" role="dialog" aria-labelledby="renameModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="renameModalLabel">重命名</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/home/rename" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" id="fileNameInput" name="file_name">
                        <input type="hidden" name="id" id="id" value="" />
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" value="确认" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- folderPlusModal -->
<div class="modal fade" id="folderPlusModal" tabindex="-1" role="dialog" aria-labelledby="folderPlusModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="folderPlusModalLabel">文件夹名</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/home/folderPlus/{{$dir}}" method="post" enctype="multipart/form-data" id="folderPlusForm">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <!--                                            <label for="fileNameInput">新文件名</label>-->
                        <input type="text" class="form-control" id="folderNameInput" name="folder_name">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" value="确认" class="btn btn-primary"  onclick="$('#folderPlusModal').modal('hide')">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- moveModal -->
<div class="modal fade" id="moveModal" tabindex="-1" role="dialog" aria-labelledby="moveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="moveModalLabel">移动到以下路径</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/home/reDir" method="post">
                <div class="modal-body">
                    @csrf
                    @if('home' != $dir)
                        <div class="custom-control custom-radio mb-2">
                            <input type="radio" id="customRadio" name="dir" value="home" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio"><span class="text-primary">home</span></label>
                        </div>
                    @endif
                    @foreach($Users_folders as $folders)
                        @if($folders->file_dir.'-'.$folders->file_name != $dir)
                            <div class="custom-control custom-radio mb-2 input-group-lg">
                                <input type="radio" id="customRadio{{$folders -> id}}" name="dir" value="{{$folders -> file_dir}}-{{$folders -> file_name}}" class="custom-control-input">
                                <label class="custom-control-label" for="customRadio{{$folders -> id}}">
                                    {{$folders -> file_dir}}-<span class="text-primary">{{$folders -> file_name}}</span>
                                </label>
                            </div>
                        @endif
                    @endforeach
                    <input type="hidden" name="mvId" id="mvId" value="" />
                </div>
                <input type="hidden" name="id" value=""/>
                <div class="modal-footer">
                    <input type="submit" value="确定" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- toast -->
<div class="toast fixed-bottom m-3" id="myToast">
<!--    <div class="toast-header">-->
<!--            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-files" fill="currentColor" xmlns="http://www.w3.org/2000/svg">-->
<!--                <path fill-rule="evenodd" d="M3 2h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H3z"/>-->
<!--                <path d="M5 0h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2v-1a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1H3a2 2 0 0 1 2-2z"/>-->
<!--            </svg>-->
<!--        <strong class="mr-auto"><i class="fa fa-grav"></i> 提示</strong>-->
<!--        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>-->
<!--    </div>-->
    <div class="toast-body" id="myToastText">
        文件链接已复制到剪贴板
    </div>
</div>

@endsection
