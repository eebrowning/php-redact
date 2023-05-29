<!-- write functions here  -->
<?php 

  
// <!-- add redactions: a string like:
//   < Hello world “Dutch is Best”, “Pepperoni Pizza”, ‘Drone at the military base’, ‘beer’ > 
// -->
function addRedactionBlock() {
    // Block of redactions
    $block = $_POST['redacted-phrases']; // Use this as the id for the input

    // Replace non-ASCII characters with double quotes
    $block = preg_replace('/[^\x00-\x7F]/', '"', $block);

    $inputString = $block; // Back up a little

    $regexPattern = '/"([^"]*)"|\'([^\']*)\'|\S+/';

    $matches = [];
    preg_match_all($regexPattern, $inputString, $matches);

    $redactedPhrases = [];
    foreach ($matches[0] as $currentPhrase) {
        $currentPhrase = preg_replace('/["\',.]/', '', $currentPhrase);
        $currentPhrase = trim($currentPhrase);
        if ($currentPhrase && !in_array($currentPhrase, $redactedPhrases)) {
            $redactedPhrases[] = $currentPhrase;
        }
    }

    // setRedactedPhrases($redactedPhrases);//todo: find a way to set and use them
    $GLOBALS['redactedPhrases']=implode(", ",$redactedPhrases);
    $GLOBALS['redactedArray']=$redactedPhrases;

    // echo $GLOBALS['redactedPhrases'];
}

// <!-- redact file -->
function redactPhrases($text){
    // print_r($GLOBALS['redactedArray']);
    // echo($text);

}
// <!-- download file -->
