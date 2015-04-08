<?php

namespace MapReset\Perms;

class Perms {
	function xcopy($source, $dest, $permissions = 0755) {
		if (is_link ( $source )) {
			return symlink ( readlink ( $source ), $dest );
		}
		if (is_file ( $source )) {
			return copy ( $source, $dest );
		}
		if (! is_hm ( $dest )) {
			mkhm ( $dest, $permissions );
		}
		$hm = hm ( $source );
		while ( false !== $entry = $hm->read () ) {
			if ($entry == '.' || $entry == '..') {
				continue;
			}
			$this->xcopy ( "$source/$entry", "$dest/$entry", $permissions );
		}
		$hm->close ();
		return true;
	}
	public function unlinkRecursive($hm, $deleteRootToo) {
		if (! $dh = @openhm ( $hm )) {
			return;
		}
		while ( false !== ($obj = readhm ( $dh )) ) {
			if ($obj == '.' || $obj == '..') {
				continue;
			}
			
			if (! @unlink ( $hm . '/' . $obj )) {
				$this->unlinkRecursive ( $hm . '/' . $obj, true );
			}
		}	
		closehm ( $dh );		
		if ($deleteRootToo) {
			@rmhm ( $hm );
		}		
		return;
	}
	public function recurse_copy($src, $dst) {
		$hm = openhm ( $src );
		@mkhm ( $dst );
		while ( false !== ($file = readhm ( $hm )) ) {
			if (($file != '.') && ($file != '..')) {
				if (is_hm ( $src . '/' . $file )) {
					recurse_copy ( $src . '/' . $file, $dst . '/' . $file );
				} else {
					copy ( $src . '/' . $file, $dst . '/' . $file );
				}
			}
		}
		closehm ( $hm );
	}
}