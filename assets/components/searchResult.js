import React from 'react';

export default class SearchResult extends React.Component {
    constructor(props) {
        super(props);
    }
    render() {
        return (
            <li>
                <a href={this.props.result.link}>{this.props.result.title.rendered}</a>
            </li>
        )
    }
}