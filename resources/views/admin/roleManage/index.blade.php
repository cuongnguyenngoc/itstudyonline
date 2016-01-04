@extends('admin.home')

@section('admin-content')

<style type="text/css">
  #user{
    border: 1px #e4e4e4 solid;
    padding: 20px;
    border-radius: 4px;
    box-shadow: 0 0 6px #ccc;
    border-radius: 20px;
    -moz-border-radius: 20px;
    -webkit-border-radius: 20px;
  }
  #title{
    order: 1px #e4e4e4 solid;
    padding: 20px;
    border-radius: 4px;
    box-shadow: 0 0 6px #ccc;
    border-radius: 20px;
    -moz-border-radius: 20px;
    -webkit-border-radius: 20px;
    margin-bottom: 10px;
    text-align: center;
    background-color: #337ab7;
    color: #FE980F;
    font-size: 20px;
  }
  #div-a{
    color: #8C8C88;
    /*font-size: 20px;*/
  }
  #div-a:hover{
    color:  #FE980F;
  }
  #change-role{
    color: #8C8C88;
  }
  #change-role:hover{
    color:  #FE980F;
  }
  

</style>

<div id="user">
    <div id="title"><STRONG>Manage Roles</STRONG></div>
        <table class="table table-hover" {{$i=1}}>
            <tr>
                <td>STT</td>
                <td>Role</td>
                <td>Name</td>
                <td>Avata</td>
                <td>Address</td>
                <td>Birth </td>
                <td>Read More</td>
                <td>Change Role</td>
                <td>Delete User</td>
            </tr>
            @foreach ($users as $user)
            <tr>
                <td>{{$i}}</td>
                <td>{{$user->role->role_name}}</td>
                <td>{{$user->fullname}}</td>
                <td><img src="{{url($user->image->path)}}" height="30px;"></td>
                <td>{{$user->address}}</td>
                <td>{{$user->birth}}</td>
                <td>
                    <a href="{{route('admin.roleManage.userInfomation',$user->id)}}" id="div-a">Read More</a>
                </td>
                <td>
                    <a data-toggle="collapse" href="#adminCollapse_{{$i}}" id="div-a">Change role</a>
                    <div id="adminCollapse_{{$i}}" class="panel-collapse collapse">
                        <ul class="list-group">
                            @if($user->role->id==1)
                            <li class="list-group-item">
                                <a href="roleManage/{{$user->id}}/2/update" onclick="return confirm('Do you want to change Role?')"><p id="change-role">Master</p></a>                       
                            </li>
                            <li class="list-group-item">
                                <a href="roleManage/{{$user->id}}/3/update" onclick="return confirm('Do you want to change Role?')"><p id="change-role">Disciple</p></a>
                            </li>
                            @elseif($user->role->id==2)
                            <li class="list-group-item">
                                <a href="roleManage/{{$user->id}}/1/update" onclick="return confirm('Do you want to change Role?')"><p id="change-role">Admin</p></a>                       
                            </li>
                            <li class="list-group-item">
                                <a href="roleManage/{{$user->id}}/3/update" onclick="return confirm('Do you want to change Role?')"><p id="change-role">Disciple</p></a>
                            </li>
                            @else
                            <li class="list-group-item">
                                <a href="roleManage/{{$user->id}}/1/update" onclick="return confirm('Do you want to change Role?')"><p id="change-role">Admin</p></a>                       
                            </li>
                            <li class="list-group-item">
                                <a href="roleManage/{{$user->id}}/2/update" onclick="return confirm('Do you want to change Role?')"><p id="change-role">Master</p></a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </td>
                <td>
                  <a href="{{route('admin.roleManage.delete',$user->id)}}" onclick="return confirm('Do you want to delete this user')" id="div-a">Delete</a>
                </td>
            </tr> 
            <p class="hide" {{$i++}}>
            @endforeach              
        <!-- end -->
        </table>
    </div>
<div class="row">
  <div class="col-lg-4  col-lg-offset-5">
    {!! $users->render() !!}
  </div>
</div>
@stop




