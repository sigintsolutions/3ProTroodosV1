<?php
//Getting count for chart
if ($count==0){?>
<div id="datalable0"></div>

<?php }

for($i=0;$i<$count;$i++) { ?>
	<div class="euzscrollbar" style="width:100%;overflow-x:scroll;overflow-y:hidden;scrollbar-color: #cacaca white;scrollbar-width:thin;">
<div id="datalable<?php echo $i;?>" style="width:5000px;"></div></div>
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