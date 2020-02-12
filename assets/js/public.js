import React from 'react';
import ReactDOM from 'react-dom';
import SearchForm from '../components/searchForm';

const searchFormElement = <SearchForm />;
const searchFields = document.getElementsByClassName('woocommerce-product-search');

if ( searchFields.length ){
    for ( let i = 0; i < searchFields.length; i++ ){
        // console.log( searchFields[ i ]);
        ReactDOM.render(
            searchFormElement,
            searchFields[ i ]
        )
    }
}