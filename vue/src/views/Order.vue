<template>
	<div>
		<Nav></Nav>

		<div class="container" v-if="!state.add">
			<div class="card mt-4">
				<div class="card-header">
                    Order
                </div>

				<div class="card-body">
					<button type="button" class="btn btn-primary" @click="state.add = true">Add Order</button>
					<table class="table mt-4">
						<thead>
							<tr>
                                <th>ID</th>
                                <th>Bus Plate Number</th>
                                <th>Driver Name</th>
                                <th>Contact Name</th>
                                <th>Contact Phone</th>
                                <th>Start Rent Date</th>
                                <th>Total Rent Days</th>
                                <th>Action</th>
                            </tr>
						</thead>
						<tbody>
							<tr v-for="order in orders" :key="order.id">
								<td>{{ order.id }}</td>
								<td>{{ order.bus }}</td>
								<td>{{ order.driver }}</td>
								<td>{{ order.contact_name }}</td>
								<td>{{ order.contact_phone }}</td>
								<td>{{ order.start_rent_date }}</td>
								<td>{{ order.total_rent_days }}</td>
								<td>
									<button type="button" class="btn btn-sm btn-danger" @click="destroy(order.id)">Delete</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="container" v-if="state.add">
			<div class="card mt-4">
				<div class="card-header">
                    Create Order
                </div>
				<div class="card-body">
					<form @submit.prevent="create">
						<div class="form-group">
                            <label for="contact-name">Contact Name</label>
                            <input type="text" class="form-control" id="contact-name" name="contact_name" placeholder="Enter contact name" v-model="formData.contact_name">
                        </div>
                        <div class="form-group">
                            <label for="contact-phone">Contact Phone</label>
                            <input type="text" class="form-control" id="contact-phone" name="contact_phone" placeholder="Enter contact phone" v-model="formData.contact_phone">
                        </div>
                        <div class="form-group">
                            <label for="start">Start Rent Date</label>
                            <input type="date" class="form-control" id="start" name="start_rent_date" placeholder="Enter start rent date" v-model="formData.start_rent_date">
                        </div>
                        <div class="form-group">
                            <label for="total">Total Rent Days</label>
                            <input type="text" class="form-control" id="total" name="total_rent_days" placeholder="Enter total rent days" v-model="formData.total_rent_date">
                        </div>

						<button type="submit" class="btn btn-primary mr-1">Add Order</button>
						<button type="button" class="btn btn-danger" @click="state.add = false">Cancel</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import axios from 'axios'
import Nav from '@/components/Nav.vue'

export default {
	components: {
		Nav
	},
	data() {
		return {
			header: {
				headers: {
					Authorization: `Bearer ${localStorage.getItem('token')}`
				}
			},
			orders: {},
			state: {
				add: false
			},
			formData: {
				contact_name: '',
				contact_phone: '',
				start_rent_date: '',
				total_rent_days: ''
			},
			editData: {}
		}
	},
	methods: {
		getOrders() {
			axios.get(`orders`, this.header)
				.then(res => {
					this.orders = res.data;
				})
				.catch(err => {
					alert(err.response.data.message);
				});
		},
		create() {
			axios.post(`orders`, this.formData, this.header)
				.then(res => {
					this.formData.contact_name = '';
					this.formData.contact_phone = '';
					this.formData.start_rent_date = '';
					this.formData.total_rent_days = '';
					this.state.add = false;

					this.getOrders();
				})
				.catch(err => {
					alert(err.response.data.message);
				}); 
		},
		destroy(id) {
			axios.delete(`orders/${id}`, this.header)
				.then(res => {
					this.getOrders();
				})
				.catch(err => {
					alert(err.response.data.message);
				}); 
		}
	},
	created() {
		this.getOrders();
	}
}
</script>