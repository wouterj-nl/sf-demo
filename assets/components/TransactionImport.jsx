import React from 'react';

import 'style/badge';

export default class extends React.Component {
    constructor(props) {
        super(props);
        this.state = { description: this.props.description, money: this.props.money };
    }

    handleDescriptionChange(e) {
        this.setState({ description: e.target.value });
    }

    render() {
        return (
            <form>
                <span className="badge  badge--neutral">{this.state.money}</span>

                <input type="text" value={this.state.description} onChange={this.handleDescriptionChange} />

                <select>
                    <option value="1">Something</option>
                    <option value="2">Otherthing</option>
                </select>

                <select>
                    <option value="1">Something</option>
                    <option value="2">Otherthing</option>
                </select>
            </form>
        );
    }
}
