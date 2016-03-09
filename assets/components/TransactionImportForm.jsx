import React from 'react';
import jQuery from 'jquery';

import TransactionImport from 'components/TransactionImport';

export default class extends React.Component {
    constructor(props) {
        super(props);
        this.state = { transactions: [] };
    }

    handleFileSelect(e) {
        var file = e.target.files[0];

        if ('text/plain' != file.type) {
            return;
        }

        var reader = new FileReader();

        reader.onload = function (e) {
            jQuery.post({
                url: '/api/transactions/import',
                data: e.target.result,
                dataType: 'json',
                success: function (data) {
                    this.setState({ transactions: data });
                }.bind(this)
            });
        }.bind(this);

        reader.readAsText(file);
    }

    render() {
        var transactionImportNodes = this.state.transactions.map(function (transaction) {
            return <TransactionImport key={transaction.id} money={transaction.money.amount} description={transaction.description} />;
        });

        return (
            <div>
                <input type="file" onChange={this.handleFileSelect} />

                {transactionImportNodes}
            </div>
        );
    }
}
