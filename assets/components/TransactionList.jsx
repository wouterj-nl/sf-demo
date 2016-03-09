import React from 'react';
import jQuery from 'jquery';

import Transaction from 'components/Transaction';

import 'style/transaction';

export default class extends React.Component {
    constructor(props) {
        super(props);
        this.state = { transactions: [] };
    }

    componentDidMount() {
        jQuery.ajax({
            url: '/api/wallets/' + this.props.walletId + '/transactions',

            success: function (transactions) {
                this.setState({ transactions: transactions });
            }.bind(this),

            error: function (xhr, status, err) {
                console.error('GET /api/wallets/' + this.props.walletId + '/transactions', status, err.toString());
            }.bind(this)
        });
    }

    render() {
        var transactionNodes = this.state.transactions.slice(0, 5).map(function (transaction) {
            var isDebit = transaction.to.id == this.props.walletId;

            return (
                <Transaction key={transaction.id} isDebit={isDebit} money={transaction.money.amount} description={transaction.description} />
            );
        }.bind(this));

        return (
            <ul className="transaction-list">
                {transactionNodes}
            </ul>
        );
    }
}
