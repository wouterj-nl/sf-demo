import React from 'react';
import jQuery from 'jquery';

import 'style/form';
import 'style/action-button';

export default class extends React.Component {
    constructor(props) {
        super(props);
        this.state = { description: '', owner: false };
        this.handleDescriptionChange = this.handleDescriptionChange.bind(this);
        this.handleOwnerChange = this.handleOwnerChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleDescriptionChange(e) {
        this.setState({ description: e.target.value });
    }

    handleOwnerChange(e) {
        this.setState({ owner: e.target.checked });
    }

    handleSubmit(e) {
        e.preventDefault();

        jQuery.post({
            url: '/api/wallets',
            dataType: 'json',
            data: {
                name: this.state.description,
                owner: this.state.owner ? 'ours' : 'theirs'
            },

            success: function (data) {
                this.props.onNewWallet({
                    id: data.wallet_id,
                    name: this.state.description,
                    money: 'EUR 0',
                    owner: this.state.owner ? 'ours' : 'theirs'
                });
            }.bind(this),

            error: function (xhr, status, err) {
                console.error('POST /api/wallets', status, err.toString());
            }
        });
    }

    render() {
        return (
            <section className="wallet  wallet--form">
                <header className="wallet__header">
                    <h1 className="wallet__name">Create a new one</h1>
                </header>

                <form onSubmit={this.handleSubmit}>
                    <input type="text" placeholder="Description"
                           value={this.state.description} onChange={this.handleDescriptionChange}
                    />
                    <br/>
                    <label><input type="checkbox" onChange={this.handleOwnerChange}/> Is this yours?</label>

                    <input type="submit" value="Create" className="action-button action-button--wallet"/>
                </form>
            </section>
        );
    }
}
