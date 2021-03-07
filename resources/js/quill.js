import Quill from 'quill/core';

import Toolbar from 'quill/modules/toolbar';
import Snow from 'quill/themes/snow';

import Blockquote from 'quill/formats/blockquote';
import Bold from 'quill/formats/bold';
import Italic from 'quill/formats/italic';
import Link from 'quill/formats/link';
import List from 'quill/formats/list';
import Header from 'quill/formats/header';


Quill.register({
    'modules/toolbar': Toolbar,
    'themes/snow': Snow,
    'formats/blockquote': Blockquote,
    'formats/bold': Bold,
    'formats/italic': Italic,
    'formats/link': Link,
    'formats/list': List,
    'formats/header': Header
});


export default Quill;
