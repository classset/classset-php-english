<?php
/**
 *  Copyright 2013 Gabriel Nicolás González Ferreira <gabrielinuz@gmail.com> 
 *
 *  Permission is hereby granted, free of charge, to any person obtaining
 *  a copy of this software and associated documentation files (the
 *  "Software"), to deal in the Software without restriction, including
 *  without limitation the rights to use, copy, modify, merge, publish,
 *  distribute, sublicense, and/or sell copies of the Software, and to
 *  permit persons to whom the Software is furnished to do so, subject to
 *  the following conditions:
 *
 *  The above copyright notice and this permission notice shall be
 *  included in all copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 *  EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 *  MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 *  NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 *  LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 *  OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 *  WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 **/

class V_CreateRoleForm implements IView
{
    public function display()
    {
        $session = SessionFactory::create();
        $dom = DOMHandlerFactory::create();
        $dom->setDocumentFromFile(ROLES_HTML)
                
            ->whereIdIs('login-user')
            ->insertNode($session->get('session-user-name'))

            ->whereIdIs('create-update-form')
            ->removeAttribute('style="display: none;"')
            ->whereIdIs('save-button')
            ->insertAttribute('name="A_CreateRole"')
               
            ->display();
    }
}