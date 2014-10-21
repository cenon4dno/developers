<?php
/*
 * Author: Cenon Ebora
 * Description: Develop a solution that simulate the delivery of notes when a client does a withdraw in a cash machine.
 *
 * The basic requirements are the follow:
 *
 * Always deliver the lowest number of possible notes;
 * It's possible to get the amount requested with available notes; * The client balance is infinite; Saldo do cliente é infinito;
 * Amount of notes is infinite;
 * Available notes R$ 100,00; R$ 50,00; R$ 20,00 e R$ 10,00
 *
 *
 * Developers: No need for framework just a simple PHP function would do.
 */

// Global Variables
$arrNotesAvailable = array(100,50,20,10);
$arrResults = array();
$bPost = false;
$bEmpty = false;
$bError = false;

// Check if POST is present
if (isset($_POST['amount'])) {

    // Set true to tell the page that it has a POST
    $bPost = true;

    try {
        if (is_numeric($_POST['amount'])) {
            $arrResults = computeNotes($_POST['amount'], $arrNotesAvailable);
        } else {
            // Invalid character check except the word NULL
            if (strtolower($_POST['amount']) == 'null') {
                $bEmpty = true;
            } else {
                throw new Exception('InputNotANumberException');
            }
        }
    } catch (Exception $e) {
        $strError = 'Caught exception: ' . $e->getMessage() . "\n";
        $bError = true;
    }
}

/**
 * Function that will compute the lowest possible notes
 * @param int $intAmount
 * @param arrayOfInt $arrNotesAvailable
 */
function computeNotes($intAmount, $arrNotesAvailable) {
    // Local variables
    $intNote = 0;
    $intTempVal = 0;
    $arrResults = array();

    // Sort the available sort first - incase available sort not in order
    rsort($arrNotesAvailable, SORT_NUMERIC);

    if (!empty($intAmount)) {
        if ($intAmount > 0) {
            // Loop through the notes available
            foreach($arrNotesAvailable as $intNote) {

                // Do division here
                $intTempVal = (int) ($intAmount/$intNote);

                if ($intTempVal > 0) {
                    // Push to result array
                    $arrResults[$intNote] = (int) ($intAmount/$intNote);
                    // Compute for the remaining amount
                    $intAmount = $intAmount - ($intNote * $arrResults[$intNote]);
                }

                // Check if withdrawal notes are done
                if ($intAmount > 0) {
                    continue;
                } else {
                    break;
                }
            }

            if ($intAmount > 0) {
                // Error value not possible to withdraw
                throw new Exception('NoteUnavailableException');
            }
        } else {
            // Error value not possible to withdraw
            throw new Exception('InvalidArgumentException');
        }
    }

    return $arrResults;
}

/**
 * Function that will display notes
 * @param array $arrResults
 */
function displayWithDrawn($arrResults) {
    // Local Variables
    $strResult = "[";
    $key = 0;
    $value = 0;

    foreach ($arrResults as $key=>$value) {
        if ($value > 0) {
            for($i=1; $i<=$value; $i++) {
                $strResult .= $key.".00 ";
            }
        }
    }

    return $strResult . "]";
}

/**
 * Function that will display denomination
 * @param array $arrResults
 */
function displayDenomination($arrResults) {
    // Local Variables
    $strResult = "";
    $key = 0;
    $value = 0;

    foreach ($arrResults as $key=>$value) {
        if ($value > 0) {
            $strResult .= $value . " of " . $key . "<br />";
        }
    }

    return $strResult;
}
?>

<html>
    <head>
        <title>Cash Register</title>
        <!-- Just for my own pleasure, I will give it a little CSS -->
        <style>
            body > div:nth-child(1) {
                margin: auto;
                width: 400px;
            }
            body > div > div:nth-child(1) {
                border: 1px solid black;
                background-color: #D5D4D1;
            }
            body > div > div:nth-child(2) {
                margin-top: 20px;
                border: 1px solid blue;
                background-color: #D5D4D1;
            }
        </style>
    </head>
    <body>
        <div>
            <div>
                <form action="" method="POST">
                    <!-- They will enter amount here -->
                    Enter Amount:
                    <input type="text" name="amount" value="<?php echo ($bPost) ? $_POST['amount'] : ''; ?>" />
                    <input type="submit" value="withdraw" />
                </form>
            </div>
            <?php if ($bPost && !$bError) :?>
            <div>
                <strong>Money Withdrawn: </strong><br />
                <?php
                    if (!$bEmpty) {
                        echo displayWithDrawn($arrResults, $bEmpty);
                    } else {
                        echo "[Empty Set]";
                    }
                ?>
                 <br />
                 <br />
                <?php if (!$bEmpty) :?>
                <strong>Money Denomination:</strong><br />
                <?php
                        echo displayDenomination($arrResults);
                ?>
                <?php endif; ?>
            </div>
            <?php elseif ($bError): ?>
            <strong>Error: </strong><br />
            <?php echo $strError; ?>
            <?php endif; ?>
        </div>
    </body>
</html>