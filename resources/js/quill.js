import Quill from 'quill/core';

import Toolbar from 'quill/modules/toolbar';
import Snow from 'quill/themes/snow';

Quill.register({
    'modules/toolbar': Toolbar,
    'themes/snow': Snow,
});

export default Quill;
