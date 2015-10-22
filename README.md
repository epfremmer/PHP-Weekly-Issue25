# Challenge 025: Vigenère Cipher

## Challenge

The challenge this week is to implement the famous Vigenère cipher. The Wikipedia article explains well how it works, 
but here’s a short description anyway:

You take a message that you want to encrypt, for instance “THECAKEISALIE” (lets assume that all characters are upper-case 
and there are no spaces in the messages, for the sake of simplicity), and a key you want to encrypt it with, for 
instance “GLADOS”. You then write the message with the key repeated over it, like this:

    GLADOSGLADOSG
    THECAKEISALIE

The key is repeated as often as is needed to cover the entire message.

Now, one by one, each letter of the key is “added” to the letter of the clear-text to produce the cipher-text. That 
is, if A = 0, B = 1, C = 2, etc, then E + G = K (because E = 4 and G = 6, and 4 + 6 = 10, and K = 10). If the sum is 
larger than 25 (i.e. larger than Z), it starts from the beginning, so S + K = C (i.e. 18 + 10 = 28, and 28 – 26 is equal 
to 2, which is C).

For a full chart of how characters combine to form new characters, see here

The cipher text then becomes:

    GLADOSGLADOSG
    THECAKEISALIE
    -------------
    ZSEFOCKTSDZAK

Write functions to both encrypt and decrypt messages given the right key.

## Approach

I have been wanting to try and learn more about the concept of reactive programing. I thought that this challenge 
was a good candidate for this paradigm, as it relies heavily on streaming data through multiple transformations before
being returned as output.

I decided to try out [ReactPHP](http://reactphp.org/)'s react/stream and react/event-loop libraries to accomplish 
the data transformations. Essentially I read off of stdin into a stream and pipe that to an encrypting & decrypting 
to handle data transformations before returning the result to another stream configured to write to stdout.

I also adding a logging stream for logging some debug information as cipher streams are writing, and a quit stream
listening for the `exit` command to end the event loop.

This is quite above and beyond the scope of this challenge, but I wanted to learn more about this pattern. I would love
to get some feedback on peoples thoughts about this implementation and possible use cases for this or similar patterns
they have experimented with in PHP.

## Installation

1. `composer install`

## Useage

1. Run `php index.php`
1. Type input into stdin (ex. THECAKEISALIE)
1. Debug output will display input, encrypted, & decrypted values as they pass through the application
1. Final output is the original value after it has been fully encrypted & decrypted
