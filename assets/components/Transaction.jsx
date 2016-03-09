import React from 'react';

export default class extends React.Component {
    render() {
        var classAttr = 'badge  badge--' + (this.props.isDebit ? 'green' : 'red');

        return (
            <li>
                <span className={classAttr}>{this.props.isDebit ? '' : '-'}{this.props.money}</span> {this.props.description}
            </li>
        );
    }
}
