<?php
for($i = 1; $i < 10; $i++)
{
	for($j = 1; $j < 10; $j++)
	{
		echo '&nbsp;&nbsp;' . $j . ' x ' . $i . ' = ' . ($i * $j);
		if($i == $j)
		{
			echo  '<br />';
			break;
		}
	}
}
?>