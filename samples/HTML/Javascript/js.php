<html>
<body>
<?php
//ini_set('include_path','.:/data/peartest/share/pear');
//ini_set('include_path','.:/data/pear/cvsroot/pear:/data/pear/cvsroot/php4/pear');
require_once 'HTML/Javascript.php';
require_once 'HTML/Javascript/Convert.php';
// ,array(741,742,743)
$test   = array(
            "foo1"=>"this \\ is a string test &\" and 'nothing' must failed",
            "foo2"=>2,
            "foo3"=>3,
            "foo4"=>4,
            "foo5"=>5,
            "foo6"=>6,
            "foo7"=>array(
                        71,
                        72,
                        73,
                        "foo74"=>array(
                                        741,
                                        742,
                                        743
                                        )
                    )
        );

$js = new HTML_Javascript();
echo $js->startScript();

echo HTML_Javascript_Convert::convertArray( $test, 'arTest', true );
echo HTML_Javascript::alert('toto');
echo HTML_Javascript::prompt('toto','toto');
echo $js->confirm('sure', 'Are you sure?!');
echo $js->popup('win', './test.html', 'window', 200, 200, false);
echo $js->popupWrite('win2', 'Foo? Bar!', 'window2222222222222222222222', 200, 200, true);
echo $js->endScript();
?>
<script>


function interrogate(what) {
    var output = '';
    for (var i in what){
        output += i+ " ";
    }
    alert(output);
}

</script>
</body>
</html>
