@extends('Dashboard::layouts.main')

@section('content')
<div id="pendaftaran-mpm-content" class="m-content">
    <div class="mc-header">
        <style>
            #pendaftaran-mpm-content > .mc-header {
                background: url('/assets/img/pmpm.jpg') no-repeat center center;
                background-size: cover;
            }
        </style>
        <div class="mch-text">
            <h2>Daftar Pengguna</h2>
        </div>
    </div>
    <div class="mc-breadcrumb" data-uk-sticky="{top:60}">
        <ul class="uk-breadcrumb">
            <li><a href="{{ URL('/dashboard') }}">Dashboard</a></li>
            <li><a href="javascript:;">Daftar Pengguna</a></li>
        </ul>
    </div>
    <div class="mc-form">
        <div class="mc-form-wrapper">
            <div class="mc-form-inner">
                <div>
                    <div class="mcf-content">
                        <div class="mcf-title">
                            <h3>Daftar Pengguna MPM</h3>
                        </div>
                        <div class="main-table">
                            <div class="mt-wrapper">
                                <div class="mt-inner">
                                    <div class="mt-aksi">
                                        <div class="uk-clearfix">
                                            <div class="uk-float-right">
                                                <ul>
                                                    <li><a href="{{ URL('/pengguna/registrasi') }}"><button class="button-add">Tambah</button></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <table class="uk-table uk-table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Nama Lengkap</th>
                                                    <th>Email</th>
                                                    <th>Kontak</th>
                                                    <th>Status user</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php($i = empty($_GET['page']) ? 1 : ((($_GET['page'] - 1) * 10) + 1))
                                                @foreach($user as $listuser)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $listuser->fullname }}</td>
                                                    <td>{{ $listuser->email }}</td>
                                                    <td>{{ $listuser->kontak }}</td>
                                                    <td>{{ App\Models\UserStatus::getstatus($listuser->status_admin) }}</td>
                                                    <td>
                                                        <div class="uk-button-group">
                                                            <button class="uk-button" type="button">Aksi</button>
                                                            <div data-uk-dropdown="{mode:'click', pos:'bottom-right'}">
                                                                <button class="uk-button" type="button"><i class="uk-icon-caret-down"></i></button>
                                                                <div class="uk-dropdown uk-dropdown-small">
                                                                    <ul>
                                                                        <li><a href="{{ URL('/pengguna/update/').'/'.$listuser->_id }}">Edit</a></li>
                                                                        <li><a href="javascript:;" data-id="{{ $listuser->_id }}" id="del-user">Hapus</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    @if($user->lastPage() > 1)
                                    <div class="pagination uk-clearfix">
                                        <div class="uk-float-right">
                                            <ul class="uk-pagination">
                                                <li class="{{ ((empty($_GET['page'])) || ($_GET['page'] == 1)) ? 'uk-disabled' : '' }}"><a href="{{ URL('/pengguna').'?page='.(!empty($_GET['page']) ? ($_GET['page'] - 1) : '1') }}"><i class="uk-icon-caret-left"></i></a></li>
                                                @php($pageNow = empty($_GET['page']) ? 1 : $_GET['page'])
                                                @if($user->lastPage() > 12)
                                                    <li class="{{ ($pageNow == 1) ? 'uk-active' : '' }}"><a href="{{ URL('/pengguna').'?page=1' }}">1</a></li>
                                                    <li class="uk-active"><a href="javascript:;">...</a></li>
                                                    @if($pageNow == 1)
                                                        @php($pagefirst = 2)
                                                        @for($i = $pagefirst;$i <= $pagefirst + 4; $i++)
                                                        <li class="{{ ($pageNow == $i) ? 'uk-active' : '' }}"><a href="{{ URL('/pengguna').'?page='.$i }}">{{ $i }}</a></li>
                                                        @endfor
                                                    @else
                                                        @php($pagelast = ($user->lastPage() - 1) - $pageNow)
                                                        @if($pagelast >= 4)
                                                            @for($i = $pageNow;$i <= $pageNow + 4; $i++)
                                                            <li class="{{ ($pageNow == $i) ? 'uk-active' : '' }}"><a href="{{ URL('/pengguna').'?page='.$i }}">{{ $i }}</a></li>
                                                            @endfor
                                                        @else
                                                            @if($user->lastPage() == $pageNow)
                                                                @for($i = $pageNow - 5;$i <= ($pageNow - 5) + 4; $i++)
                                                                <li class="{{ ($pageNow == $i) ? 'uk-active' : '' }}"><a href="{{ URL('/pengguna').'?page='.$i }}">{{ $i }}</a></li>
                                                                @endfor
                                                            @else
                                                                @for($i = $pageNow - 4;$i <= ($pageNow - 4) + 4; $i++)
                                                                <li class="{{ ($pageNow == $i) ? 'uk-active' : '' }}"><a href="{{ URL('/pengguna').'?page='.$i }}">{{ $i }}</a></li>
                                                                @endfor
                                                            @endif
                                                        @endif
                                                    @endif
                                                    <li class="uk-active"><a href="javascript:;">...</a></li>
                                                    <li class="{{ ($pageNow == $user->lastPage()) ? 'uk-active' : '' }}"><a href="{{ URL('/pengguna').'?page='.$user->lastPage() }}">{{ $user->lastPage() }}</a></li>
                                                @else
                                                    @for($i = 1;$i <= $user->lastPage(); $i++)
                                                        <li class="{{ ($pageNow == $i) ? 'uk-active' : '' }}"><a href="{{ URL('/pengguna').'?page='.$i }}">{{ $i }}</a></li>
                                                    @endfor
                                                @endif
                                                <li class="{{ ((!empty($_GET['page'])) && ($_GET['page'] == $user->lastPage())) ? 'uk-disabled' : '' }}"><a href="{{ URL('/pengguna').'?page='.(!empty($_GET['page']) ? ($_GET['page'] + 1) : '2') }}"><i class="uk-icon-caret-right"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div id="modal-del" class="uk-modal">
    <div class="uk-modal-dialog">
        <div class="uk-modal-header">
            <div class="uk-clearfix">
                <div class="uk-float-left">
                    <h3>Peringatan!</h3>
                </div>
                <div class="uk-float-right">
                    <button class="uk-modal-close uk-close"></button>
                </div>
            </div>
        </div>
        <div class="modal-content">
            <p>Apakah anda yakin ingin menghapus data ini?</p>
            <div id="alert-modal" class="uk-alert uk-alert-large uk-hidden" data-uk-alert>
                <p></p>
            </div>
        </div>
        <div class="uk-modal-footer">
            <ul>
                <li><button class="button-blue uk-modal-close" >Tidak</button></li>
                <li><button class="button-red" data-id="" id="delUser">Ya</button></li>
            </ul>
        </div>
    </div>
</div>
<script>
	var sidebar = 'registrasi-user';
</script>

<script src="{{ URL('/assets/js/backend/registrasi.js') }}"></script>
@stop
