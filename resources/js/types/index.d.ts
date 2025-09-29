import { InertiaLinkProps } from '@inertiajs/vue3'
import type { LucideIcon } from 'lucide-vue-next'

export interface Auth {
  user: User;
}

export interface BreadcrumbItem {
  title: string;
  href: string;
}

export interface NavItem {
  title: string;
  href: NonNullable<InertiaLinkProps['href']>;
  icon?: LucideIcon;
  isActive?: boolean;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
  name: string;
  quote: { message: string; author: string };
  auth: Auth;
  sidebarOpen: boolean;
};

export type LotStatus = 'pending' | 'active' | 'finished' | 'canceled';

// Models
export interface User {
  id: number;
  name: string;
  email?: string;
  avatar?: string;
  email_verified_at?: string | null;
  created_at?: string;
  updated_at?: string;
  bids?: Bid[];
}

export interface Auction {
  id: number;
  name: string;
  lots_count: number;
  owner: User;
  lots?: Lot[];
  created_at: string;
  updated_at: string;
}

export interface Lot {
  id: number;
  auction_id: number;
  winner_id: number | null;
  winning_bid_id: number | null;
  title: string;
  starts_at: string;
  ends_at: string;
  status: LotStatus;
  description: string | null;
  starting_price: number;
  current_price: number;
  auction?: Auction;
  bids?: Bid[];
  winner?: User;
  winnerBid?: Bid;
  created_at: string;
  updated_at: string;
}

export interface Bid {
  id: number;
  lot_id: number;
  user_id: number;
  amount: number;
  created_at: string;
  updated_at: string;
  user?: User;
  lot?: Lot;
}

export interface LotSearchResult {
    id: number;
    title: string;
    current_price: number;
    status: LotStatus;
    url: string;
}

// Forms
export interface BidForm {
  lot_id: number;
  amount: number;
}

// Store States
export interface AuctionState {
  loading: boolean;
  storing: boolean;
  searching: boolean;
  lots: Lot[];
  currentLot: Lot | null;
}

// Timer Config
export type TimeUnitKey = 'days' | 'hours' | 'minutes' | 'seconds';

export type PrevTimeUnitKey = 'prevDays' | 'prevHours' | 'prevMinutes' | 'prevSeconds';

export interface TimeConfigItem {
  unit: TimeUnitKey;
  limits: [number, number];
  prevUnit: PrevTimeUnitKey;
}

export type BreadcrumbItemType = BreadcrumbItem;
