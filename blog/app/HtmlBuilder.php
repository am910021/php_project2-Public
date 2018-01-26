<?php 

namespace App;





class HtmlBuilder{
    private $type = "";
    
    public function setType($type){
        $this->type = $type;
        return $this;
    }
    
    
    public  function build(){
        if($this->type == "GROUP"){
            return $this->groupTable();
        }else if($this->type == "USER"){
            return $this->userTable();
        }
        
        
        
    }
    
    public function  userTable(){
        $html = '<div class="row"><div class="col-sm-4"><div class="input-group">'.
            '<input type="number" id="search_id" class="form-control" placeholder="編號查詢">'.
            '<div class="input-group-addon"><a class="glyphicon glyphicon-search"></a></div>'.
            '</div></div><div class="col-sm-8"><div class="input-group">'.
            '<input type="text" id="search_username" class="form-control" placeholder="使用者名稱查詢">'.
            '<div class="input-group-addon"><a class="glyphicon glyphicon-search"></a></div></div></div>'.
            '</div><br><table id="table" class="table"><thead><tr><th>#</th><th>編號</th><th>使用者</th><th>匿稱</th>'.
            '<th>已管理數量</th></tr></thead><tbody>';
        
        $td = '<tr><td><input type="radio" name="optradio" value="%d"></td><td>%d</td><td>%s</td><td>%s</td><td>%s</td></tr>';
        
        $users = User::where([['isActive','=',true],['type','<','3']])->get();
        foreach ($users as $user){
            $html.=sprintf($td,$user->id, $user->id, $user->username ,$user->nickname, '1');
        }
        $html.='</tbody></table>';
        return  $html;
    }
    
    
    
    
    public function groupTable(){
        $html = '<div class="row"><div class="col-sm-4"><div class="input-group">'.
            '<input type="number" id="group_id" class="form-control" placeholder="編號查詢">'.
            '<div class="input-group-addon"><a class="glyphicon glyphicon-search">'.
            '</a></div></div></div><div class="col-sm-8"><div class="input-group">'.
            '<input type="text" id="group_manager" class="form-control" placeholder="名稱、管理者查詢">'.
            '<div class="input-group-addon"><a class="glyphicon glyphicon-search">'.
            '</a></div></div></div></div>'.
            '<table id="table" class="table"><thead><tr><th>#</th><th>編號</th><th>名稱</th><th>管理者</th><th>備注</th></tr></thead><tbody>';
        $str2 = '<tr><td><input type="radio" name="optradio" value="%d"></td><td>%d</td><td>%s</td><td>%s</td><td>%s</td></tr>';
        
        foreach (Group::where('canApply',true)->get() as $group)
        {
            $html.=sprintf($str2,$group->id, $group->id, $group->name ,$group->manager()->username,$group->remarks);
        };
        
        $html.='</tbody></table>';
        return  $html;
    }
    
    
    
    
    
}



