import type { AuctionState, Bid, BidForm, Lot } from '@/types'
import { defineStore } from 'pinia'

export const useAuctionStore = defineStore('auction', {
  state: (): AuctionState => ({
    loading: false,
    storing: false,
    lots: [],
    currentLot: null
  }),

  actions: {
    async fetchLots() {
      try {
        this.loading = true
        const { data } = await this.$axios.get('/api/lots')
        this.lots = data
      } catch (e: any) {
        this.$toast.add({
          severity: 'error',
          summary: 'Error fetching lots',
          detail: e.message || 'An error occurred while fetching lots.',
          life: 3000
        })
      } finally {
        this.loading = false
      }
    },
    async fetchLot(lotId: number) {
      try {
        this.loading = true
        const { data } = await this.$axios.get(`/api/lots/${lotId}`)
        this.setLot(data)
      } catch (e: any) {
        this.$toast.add({
          severity: 'error',
          summary: 'Error fetching lot',
          detail: e.message || 'An error occurred while fetching lot.',
          life: 3000
        })
      } finally {
        this.loading = false
      }
    },
    async placeBid(form: BidForm) {
      try {
        this.storing = true
        await this.$axios.post('/api/lots/bid', form)
        await this.fetchLot(form.lot_id)
      } catch (e: any) {
        this.$toast.add({
          severity: 'error',
          summary: 'Error placeBid',
          detail: e.message || 'An error occurred while placing the bid.',
          life: 3000
        })
      } finally {
        this.storing = false
      }
    },
    setLot(lot: Lot) {
      this.currentLot = lot
    },
    addNewBid(bid: Bid) {
      if (this.currentLot && this.currentLot.id === bid.lot_id) {
        this.currentLot.bids?.push(bid)
        this.currentLot.current_price = bid.amount
      }
    }
  }
})
