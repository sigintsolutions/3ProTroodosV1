<?php 
//Getting count for chart
for($i=0;$i<$count;$i++) {

 ?>
 <div class="euzscrollbar" style="width:100%;overflow-x:scroll;overflow-y:hidden;scrollbar-color: #cacaca white;scrollbar-width:thin;">
<div id="hubchart<?php echo $i;?>" class="hubdemo"></div></div>
<?php }?>
<style>
.euzscrollbar::-webkit-scrollbar {
  height: 5px;
}
.euzscrollbar::-webkit-scrollbar-track {
  background: #ffffff;  
}
.euzscrollbar::-webkit-scrollbar-thumb {
  background-color: #c1c1c1; 
  border-radius: 10px;    
}
</style>