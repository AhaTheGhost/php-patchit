## PHP PatchIt - BinaryPatcher

![GitHub release (latest by date)](https://img.shields.io/github/v/release/AhaTheGhost/php-patchit)
![GitHub](https://img.shields.io/github/license/AhaTheGhost/php-patchit)

**BinaryPatcher** is a PHP class for patching binary data. It allows you to search for specific binary patterns in a binary file and replace them with other binary patterns. This can be useful in various scenarios such as modifying game files, applying binary patches, or customizing binary data.

## What's New in Version 1.1.0.0

The latest version of BinaryPatcher, version 1.1.0.0, introduces several enhancements and improvements:

### 1. Namespace

- The class has been moved to a namespace `PatchIt` to avoid potential naming conflicts and improve code organization.

### 2. Exception Handling

- The code now includes better exception handling to provide informative error messages when issues arise during patching or initialization.

### 3. Constructor Improvements

- The constructor now expects a file path instead of a file array. This simplifies the initialization process and makes it more intuitive.

### 4. Logging

- A logging mechanism has been added to keep track of the last operation's status. You can retrieve the last log message using the `getLastLog()` method.

### 5. Updated Method Names

- Some method names and parameter names have been updated to improve code clarity and consistency.

### 6. Code Refactoring

- The code has been refactored for better readability, maintainability, and adherence to PHP coding standards.

## Getting Started

To start using BinaryPatcher, follow these steps:

1. Include the `BinaryPatcher.php` file in your PHP project.
2. Create an instance of the `PatchIt\BinaryPatcher` class, providing the file path and the binary format to unpack.
3. Use the `patchData()` method to apply patches to the binary data.
4. Retrieve the patched binary data using the `getPatchedBinary()` method.
5. Check the last operation's status using the `getLastLog()` method.

## Usage Example

Here's a simple example of how to use BinaryPatcher:

```php
use PatchIt\BinaryPatcher;
// Or
require_once 'PathTo\BinaryPatcher.php';

try {
    $patcher = new BinaryPatcher('path/to/your/binary/file.bin', 'H*');

    // Define patch pairs
    $patchPairs = [
        ['pattern1'],
        ['replacement1'],
        ['pattern2'],
        ['replacement2'],
        // Add more patch pairs as needed
    ];

    // Apply patches
    $patcher->patchData($patchPairs);

    // Get the patched binary data if $lastLog is equal to 'Success'
    if ($patcher->getLastLog() == "Success")
        $patchedData = $patcher->getPatchedBinary();

} catch (\Exception $e) {
    echo "An error occurred: " . $e->getMessage() . "\n";
}
```

---

### How to ...?

just simply by **_finding a set of values_** and **_replacing them with another set_**, essentially using **jagged arrays**.

_After including the library(BinaryPatcher.php) file then we just create the object._

_When creating the object **BinaryPatcher()** we must provide two parameters,_

- The binary file, must be stated and initialize as file path
- Unpack type while using the _**pack()**_ and _**unpack()**_ functions from PHP. The types are stated [HERE](https://www.programmersought.com/article/27944157303/)

_When using the method **patchData()** we must provide one parameter,_

- The jagged array or the array of `pairs`(**find binary array** and **replace binary array**) always must be an even number of arrays in `pairs`, in each `pair` the frist array is the "Find values" and the second is the "Replace with values".

_Finally, use the method **getPatchedBinary()** to write the new data to a variable._

### Simple test code review

Lets assume we have the following code
![Screenshot 2023-09-14 224745](https://github.com/AhaTheGhost/cs-patchit/assets/19475395/a942fec1-46be-4b46-97c9-27022eab898b)

The above code will result us as the following,
![Screenshot 2021-07-22 075540](https://user-images.githubusercontent.com/19475395/126592087-5d941060-6739-435c-ba34-43985b58514d.png)

The first ('F4', 'A2') was not caught, because we specifically said to match the whole array ('01', '88', 'F4', 'A2').
Furthermore,

- The first array was found and replaced.
- Nothing happened to the second array, because there wasn't such data.
- And finally, the third was also found and replaced.

_The algorithm was writing to make it as simple and as lightweight as possible with as little of **n** of **O(n)**. Also note that it will depend on your file size_

---

For more information and to access the code, please visit the [GitHub repository](https://github.com/AhaTheGhost/php-patchit/).
If you have any questions or encounter any issues, please feel free to [reach out](mailto:ahmad360pro@gmail.com).
Thank you for using the `PatchIt-BinaryPatcher` library, and hope you find this update beneficial.
