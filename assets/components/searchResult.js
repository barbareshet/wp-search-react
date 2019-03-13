import React from 'react';

export default class SearchResult extends React.Component {
    constructor(props) {
        super(props);
    }
    render() {
        return (
            <li>
                <a href={this.props.result.url}>{this.props.result.title}</a>
            </li>
        )
    }
}