<template>
	<KeepAlive>
		<v-container
			id="dashboard"
			fluid
			tag="section"
		>
			<v-row>
				<v-col 
			<v-col 
				<v-col 
					v-for="dashboardStat in dashboardStats"
					:key="dashboardStat.title"
				>
					<MaterialStatsCard
						:icon="dashboardStat.icon"
						:title="dashboardStat.title"
						:sub-text="dashboardStat.subText"
						:value="dashboardStat.value"
						:sub-icon="dashboardStat.subIcon"
					/>
				</v-col>
			</v-row>

			<v-card
				elevation="0"
				style="margin-top: 0px;"
			>
				<v-card-title>
					Report by {{ currentMonth }}
				</v-card-title>
				<v-row>
					<v-col md='8'>
						<MaterialSimpleChart
							type="Bar"
							:data="dashboardChartExpenseData"
							ratio="16:9"
							chartTitle= "Expense and Revenue"
						/>
					</v-col>
					<v-col md='4'>
						<MaterialSimpleChart
							type="Pie"
							:data="dashboardChartWalletData"
							ratio="4:3"
							chartTitle= "Wallets' current balance"
						/>
					</v-col>
				</v-row>
			</v-card>
		</v-container>
	</KeepAlive>
</template>

<script>
import MaterialStatsCard from '@/components/base/MaterialStatsCard'
import MaterialSimpleChart from '@/components/base/MaterialSimpleChart'
import TransferTypes from '@/enums/TransferTypes'
import { customAxios } from '@/axios'
import moment from 'moment'

export default {
	name: 'Dashboard',

	components: {
		MaterialStatsCard,
		MaterialSimpleChart,
	},

	data () {
		return {
			dashboardStats: [
				{
					icon: 'mdi-tray-arrow-down',
					title: 'Revenue',
					subText: 'This month',
					subIcon: 'mdi-calendar-multiple',
					value: 'NaN',
				},
				{
					icon: 'mdi-tray-arrow-up',
					title: 'Expense',
					subText: 'This month',
					subIcon: 'mdi-calendar-multiple',
					value: 'NaN',
				},
				{
					icon: 'mdi-wallet',
					title: 'Wallet',
					subText: 'Current balance',
					subIcon: 'mdi-archive-outline',
					value: null,
				},
			],
			wallets: null,
			monthlyTransactions: null,
			dashboardChartExpenseData: null,
			dashboardChartWalletData: null,
			currentMonth: null,
		}
	},

	// await functions defined inside
	// outside must use async (keyword pair)
	async mounted() {
		// must use await for the data to be retreived successfully
		// before processing chart data

		// getting based data
		await this.getMonthlyTransaction();
		await this.getWallets();

		// calculate 

		// calculating chart data
		this.dashboardChartExpenseData = this.calculateChartExpenseData(this.monthlyTransactions);
		this.dashboardChartWalletData = this.calculateChartWalletData(this.wallets);
	},

	methods: {
		async getMonthlyTransaction() {
			let rootComponent = this;
			// get transaction stats for dashboard
			await customAxios
				.post('/api/transaction/monthly')
				.then((response) => {
					let transactions = response.data.transactions;
					let monthlyRevenue = 0;
					let monthlyExpense = 0;

					transactions.forEach(transaction => {
						if(transaction.type == TransferTypes.EXPENSE) {
							monthlyExpense -= transaction.amount;
						} else if(transaction.type == TransferTypes.REVENUE) {
							monthlyRevenue += transaction.amount;
						}
					});

					// to be used to render chart
					this.monthlyTransactions = transactions;

					this.dashboardStats[TransferTypes.EXPENSE].value = monthlyExpense.toString();
					this.dashboardStats[TransferTypes.REVENUE].value = monthlyRevenue.toString();
				});
		},

		async getWallets() {
			let rootComponent = this;
			// get wallet stats for dashboard
			await customAxios
				.post('/api/wallet/')
				.then((response) => {
					this.wallets = response.data.wallets;

					let totalBalance = 0;
					this.wallets.forEach(wallet => {
						totalBalance += wallet.amount;
					});
					
					rootComponent.dashboardStats[2].value = totalBalance.toString();
				});
		},

		getDaysByCurrentMonth(today) {
			// +1 at the month because the month value is 0-based
			this.currentMonth = today.getFullYear() + '-' + (today.getMonth() + 1);
			const daysInMonth = moment(this.currentMonth).daysInMonth();

			return Array.from({length: daysInMonth}, (v, k) => k + 1);
		},

		calculateChartExpenseData(monthlyTransactions) {
			let data = {
				labels: [],
				series: [
					[],  // revenue
					[],  // expense
				]
			};
			// days in month from 1 to 30, 31 or 28 or 29 (as with feb)
			let today = new Date();
			let daysInMonth = this.getDaysByCurrentMonth(today);


			// get all available days in current month, eg 6-10, 6-20
			daysInMonth.forEach((dayInMonth) => {
				data.labels.push(dayInMonth);
			});
			// initialise series data
			data.series[TransferTypes.REVENUE] = new Array(daysInMonth.length).fill(0);
			data.series[TransferTypes.EXPENSE] = new Array(daysInMonth.length).fill(0);
			// calculate chart data
			monthlyTransactions.forEach((transaction) => {
				data.series
					[transaction.type]
					[parseInt(transaction.dateTime.split("-")[2])]
					+= transaction.amount;
			});

			return data;
		},

		calculateChartWalletData(lstWallets) {
			let data = {
				labels: [],	// wallet name
				series: []  // wallet balance
			};

			lstWallets.forEach((wallet) => {
				data.labels.push(wallet.name);
				data.series.push(wallet.amount);
			});

			return data;
		}
	},
}
</script>
