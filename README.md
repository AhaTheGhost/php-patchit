### What is PHP PatchIt?
It is a super easy library to edit binary files as to your need.

### How to use it?
just simply by **_finding a set of values_** and **_replacing them with another set_**, essentially using **jagged arrays**.

_After including the library(patchIt.class.php) file then we just create the object._

_When creating the object **Patch()** we must provide two parameters,_
1. The binary file, must be stated and initialize as a temp file or even right from the $_POST variable
2. Unpack type while using the _pack()_ and  _unpack()_ functions from PHP. The types are stated [here](https://www.programmersought.com/article/27944157303/)

_When using the method **patchData()** we must provide one parameter,_
1. The jagged array (array of arrays) always must be an even number of arrays, every odd array is the "Find values" and every even array is the "Replace with values".

Finally, use the method _writePatchedData()_ to write the new data to a variable.

### Simple test code review
Lets assume we have the following code
![Screenshot 2021-07-22 075811](https://user-images.githubusercontent.com/19475395/126592541-dcf0c869-1b78-4acd-b5ee-7d4211e3ecc6.png)


The above code will result us as the following,
![Screenshot 2021-07-22 075540](https://user-images.githubusercontent.com/19475395/126592087-5d941060-6739-435c-ba34-43985b58514d.png)


The first ('F4', 'A2') was not caught, because we specifically said to match the whole array ('01', '88', 'F4', 'A2').
Furthermore,
- The first array was found and replaced.
- Nothing happened to the second array, because there wasn't such data.
- And finally, the third was also found and replaced.

_The algorithm was writing to make it as simple and as lightweight as possible with as little of **n** of **O(n)**. Also note that it will depend on your file size_
