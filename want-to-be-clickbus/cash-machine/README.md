Cash Machine
============

The Problem
================

Develop a solution that simulate the delivery of notes when a client does a withdraw in a cash machine.

The basic requirements are the follow:

* Always deliver the lowest number of possible notes;
* It's possible to get the amount requested with available notes; * The client balance is infinite; Saldo do cliente é infinito;
* Amount of notes is infinite;
* Available notes R$ 100,00; R$ 50,00; R$ 20,00 e R$ 10,00

Example:
================
*
 **Entry:** 30.00
 **Result:** [20.00, 10.00]

*
  **Entry:** 80.00
  **Result:** [50.00, 20.00, 10.00]

*
  **Entry:** 125.00
  **Result:** *throw NoteUnavailableException*

*
 **Entry:** -130.00
 **Result:** *throw InvalidArgumentException*

*
  **Entry:** NULL
  **Result:** [Empty Set]

Developers Notes
================

Here is my exam, I did the cash-machine test.

File Location:
==============
https://github.com/cenon4dno/developers/tree/master/want-to-be-clickbus/cash-machine/index.php


Specifications:
===============
No specification so I did a simple PHP implementation.

Requirements:
=============
Basic PHP and Apache setup.

Tested:
=======
Cross-browser compatible: FF, Chrome, IE11 and Safari.
Other browser not tested but assumed working.

Installation:
=============
Just drop in your Apache DocumentRoot and run index.php.




