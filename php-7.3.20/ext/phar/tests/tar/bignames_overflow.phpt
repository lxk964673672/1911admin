--TEST--
Phar: tar with huge filenames, buffer overflow
--SKIPIF--
<?php if (!extension_loaded("phar")) die("skip"); ?>
--INI--
phar.require_hash=0
--FILE--
<?php
$fname = dirname(__FILE__) . '/' . basename(__FILE__, '.php') . '.tar';
$fname2 = dirname(__FILE__) . '/' . basename(__FILE__, '.php') . '.2.tar';
$pname = 'phar://' . $fname;

include dirname(__FILE__) . '/files/make.dangerous.tar.php.inc';

$tar = new danger_tarmaker($fname, 'none');
$tar->init();
$tar->addFile(str_repeat('a', 101), 'hi');
$tar->addFile(str_repeat('a', 255), 'hi2');
$tar->close();

$p1 = new PharData($fname);
foreach ($p1 as $file) {
	echo $file->getFileName(), "\n";
}
echo $p1['a/' . str_repeat('a', 100)]->getContent() . "\n";
echo $p1[str_repeat('a', 155) . '/' . str_repeat('a', 100)]->getContent() . "\n";

?>
===DONE===
--CLEAN--
<?php
unlink(dirname(__FILE__) . '/' . basename(__FILE__, '.clean.php') . '.tar');
unlink(dirname(__FILE__) . '/' . basename(__FILE__, '.clean.php') . '.2.tar');
?>
--EXPECT--
a
aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
hi
hi2
===DONE===
