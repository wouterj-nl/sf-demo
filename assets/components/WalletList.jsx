import React from 'react';
import jQuery from 'jquery';

import Wallet from 'components/Wallet';
import WalletForm from 'components/WalletForm';

import 'style/wallet';

export default class extends React.Component {
    constructor(props) {
        super(props);
        this.state = { wallets: [] };
        this.handleNewWallet = this.handleNewWallet.bind(this);
    }

    componentDidMount() {
        jQuery.ajax({
            url: this.props.url,
            dataType: 'json',
            success: function (wallets) {
                this.setState({ wallets: wallets });
            }.bind(this),
            error: function (xhr, status, err) {
                console.error('GET '+this.props.url, status, err.toString());
            }.bind(this)
        });
    }

    handleNewWallet(e) {
        this.setState({ wallets: jQuery.merge(this.state.wallets, [e]) });
    }

    render() {
        var walletNodes = this.state.wallets
            .filter(function (wallet) { return wallet.name !== '_world'; })
            .map(function (wallet) {
                return <Wallet key={wallet.id} id={wallet.id} owner={wallet.ours ? 'ours' : 'theirs'} name={wallet.name} money={wallet.money.amount}/>
            });

        return (
            <div className="wallet-list">
                {walletNodes}
                <WalletForm onNewWallet={this.handleNewWallet} />
            </div>
        );
    }
};
