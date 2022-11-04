<?php

if ($count==0){?>
<div id="datalable0"></div>

<?php }

for($i=0;$i<$count;$i++) { ?>
<div id="datalable<?php echo $i;?>" class="euzchartin" style=""></div>
<?php }?>
<style>
.euzchartin > div {
width: 5000px;
overflow-x:scroll;
overflow-y:hidden;
scrollbar-color: #cacaca white;
scrollbar-width:thin;
}
</style>