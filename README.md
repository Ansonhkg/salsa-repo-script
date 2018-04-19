# Simple Media Centre Script

1. Copy index.php
2. Folders in the root folder are treated as navigation.

## Note:
- Only support three levels depth.
  - First level folders are navigations.
  - Second level folders are category.
  - Third level folders are program type.
  - Then you will have your media files in the program folder.
  
Example of directory sturcture:

``` bash
+---Main_A
|   +---Cat_A
|   |   +---Program_1
|   |   |       Media_A.mp4
|   |   |       Media_B.mp4
|   |   |       Media_C.mp4
|   |   |       Media_D.mp4
|   |   |
|   |   +---Program_2
|   |   |       Media_A.mp4
|   |   |       Media_B.mp4
|   |   |       Media_C.mp4
|   |   |       Media_D.mp4
|   |   |
|   |   \---Program_3
|   |           Media_A.mp4
|   |           Media_B.mp4
|   |           Media_C.mp4
|   |           Media_D.mp4
|   |
|   +---Cat_B
|   |   +---Program_1
|   |   |       Media_A.mp4
|   |   |       Media_B.mp4
|   |   |       Media_C.mp4
|   |   |       Media_D.mp4
|   |   |
|   |   +---Program_2
|   |   |       Media_A.mp4
|   |   |       Media_B.mp4
|   |   |       Media_C.mp4
|   |   |       Media_D.mp4
|   |   |
|   |   \---Program_3
|   |           Media_A.mp4
|   |           Media_B.mp4
|   |           Media_C.mp4
|   |           Media_D.mp4
|   |
|   +---Cat_C
|   \---Cat_D
\---Main_B
    +---Cat_A
    |   +---Program_1
    |   |       Media_A.mp4
    |   |       Media_B.mp4
    |   |       Media_C.mp4
    |   |       Media_D.mp4
    |   |
    |   +---Program_2
    |   |       Media_A.mp4
    |   |       Media_B.mp4
    |   |       Media_C.mp4
    |   |       Media_D.mp4
    |   |
    |   \---Program_3
    |           Media_A.mp4
    |           Media_B.mp4
    |           Media_C.mp4
    |           Media_D.mp4
    |
    +---Cat_B
    |   +---Program_1
    |   |       Media_A.mp4
    |   |       Media_B.mp4
    |   |       Media_C.mp4
    |   |       Media_D.mp4
    |   |
    |   +---Program_2
    |   |       Media_A.mp4
    |   |       Media_B.mp4
    |   |       Media_C.mp4
    |   |       Media_D.mp4
    |   |
    |   \---Program_3
    |           Media_A.mp4
    |           Media_B.mp4
    |           Media_C.mp4
    |           Media_D.mp4
    |
    +---Cat_C
    \---Cat_D
```
