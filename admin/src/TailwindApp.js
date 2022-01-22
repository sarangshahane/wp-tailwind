import React from 'react';
import ReactDOM from 'react-dom';

/* Main Compnent */
// import '@Admin/TailwindApp.scss';
import AppWrapper from '@Admin/pages/AppWrapper'

ReactDOM.render(
	<React.StrictMode>
		<AppWrapper />
	</React.StrictMode>,
	document.getElementById( 'tailwind-app' )
);