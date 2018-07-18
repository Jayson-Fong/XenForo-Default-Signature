<?php
class jayson_DFS_Listener {
	public static function Listen($class, array &$extend) {
		$extend[] = 'jayson_DFS_Extend_'.$class;
	}
}
