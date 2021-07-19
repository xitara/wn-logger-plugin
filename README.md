# Simple Logger for October CMS that implements a filter for loglevels and can be active if debug=false

Clone it to a Folder in your October CMS named
`plugins\xitara\logger`

Add following line to `aliases` section in your config/app.php
`'Log' => 'Xitara\Logger\Classes\Logger',`

Add `use Log;` to your php-file and enjoy

Example code
|  |
|--|
|`Log::emergency('emergency-test');`|
|`Log::alert('alert-test');`|
|`Log::critical('critical-test');`|
|`Log::error('error-test');`|
|`Log::warning('warning-test');`|
|`Log::notice('notice-test');`|
|`Log::info('info-test');`|
|`Log::debug('debug-test');`|

Format:
`Log::[loglevel](String message[, Array context]);`

Message is the text to write to log
Description will be placed before message if message is boolean, string or numeric, not on arrays or objects
Context can be any data you like and it's optional
