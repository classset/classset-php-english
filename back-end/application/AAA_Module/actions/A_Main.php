<?php
/**
 *	Copyright 2013 Gabriel Nicolás González Ferreira <gabrielinuz@gmail.com> 
 *
 *	Permission is hereby granted, free of charge, to any person obtaining
 *	a copy of this software and associated documentation files (the
 *	"Software"), to deal in the Software without restriction, including
 *	without limitation the rights to use, copy, modify, merge, publish,
 *	distribute, sublicense, and/or sell copies of the Software, and to
 *	permit persons to whom the Software is furnished to do so, subject to
 *	the following conditions:
 *
 *	The above copyright notice and this permission notice shall be
 *	included in all copies or substantial portions of the Software.
 *
 *	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 *	EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 *	MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 *	NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 *	LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 *	OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 *	WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 **/

class A_Main implements IAction
{
	public function execute()
	{
        //SESSION
        $session = SessionFactory::create();
        
		if ($session->get("authenticated") == null) $session->set("authenticated", false);

		if ($session->get("authorized") == null) $session->set("authorized", false);

		//ACTIONS
		$actions = ActionFactory::create();
		
		//REQUESTHANDLER AND SELECTACTIONKEY
		$requestHandler = RequestHandlerFactory::create();
		$selectedActionKey = $requestHandler->getSelectedActionKey();			
		
		//VALIDATOR
		$validator = ValidatorFactory::create();
		
		//REDIRECTOR
		$redirector = RedirectorFactory::create();

		//MAIN
		$validator->ifFalse( $session->get("authenticated") )
					->execute($actions['A_Authenticate']);	
		
		$validator->ifTrue( $selectedActionKey == 'A_Logout' )
					->execute($actions['A_Logout']);

		$validator->ifFalse( $session->get("authenticated") )
					->execute($actions['A_Logout']);

		$actions['A_Authorize']->execute();

		$validator->ifFalse( $session->get("authorized") )
					->respond(NO_AUTHORIZED_ACTION);

		$validator->ifTrue( $selectedActionKey == "" )
					->redirectTo('index.php?A_ReadUsersPaginated');	

		$validator->ifTrue( $selectedActionKey == "A_Authenticate" )
					->redirectTo('index.php?A_ReadUsersPaginated');

		$validator->ifFalse( array_key_exists($selectedActionKey, $actions) )
					->respond($selectedActionKey." ".NOT_IMPLEMENTED);

		$actions[$selectedActionKey]->execute();
	}
}

?>