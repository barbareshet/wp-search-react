import React from 'react';
import SearchResults from '../components/searchResults';

export default class SearchForm extends React.Component {
    constructor(props) {
        super(props);
        this.getResults = this.getResults.bind(this);
        this.state = {
            results : [], // Results from search
            loading: false, // Are we still loading the previous results?
            searched: false // Are we actually even searching (any words in input)?
        };
    }
    getResults(e) {
        if( this.state.loading ) {
            return;
        }
        //Get the input values
        const search = e.target.value;

        //Set min of 3 Characters
        if ( search && search.length > 2 ){
            this.setState( { loading: true, searched: true });
            //change the %s into the search param of our REST URL
            let url = wp_react_js.rest_search_posts.replace( '%s', search );
            let json = fetch( url )
                .then( response => { return response.json() } )
                .then( results => { this.setState( { results: results, loading: false });
                } );
        } else {
            // No input, so we are not searching.
            this.setState({results: [], searched: false });
        }

    }
    render() {
        return (
            <div className="search-form-input">
                <input className="search-input" type="text" onKeyUp={this.getResults} />
                <SearchResults searched={ this.state.searched } loading={ this.state.loading } results={ this.state.results } />
            </div>
        )
    }
}