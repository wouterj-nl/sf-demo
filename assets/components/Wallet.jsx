import React from 'react';

import TransactionList from 'components/TransactionList';

import 'style/badge';

export default class extends React.Component {
    render() {
        var classAttr = 'wallet  wallet--' + this.props.owner;
        var moneyClassAttr = 'wallet__money  badge  badge--' + (this.props.money > 0 ? 'green' : this.props.money == 0 ? 'neutral' : 'red');

        return (
            <section className={classAttr}>
                <header className="wallet__header">
                    <h1 className="wallet__name">{this.props.name}</h1>
                    <span className={moneyClassAttr}>{this.props.money}</span>
                </header>

                <TransactionList walletId={this.props.id} />
            </section>
        );
    }
}
