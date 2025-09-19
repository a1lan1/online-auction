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

// Models
export interface User {
  id: number;
  name: string;
  email: string;
  avatar?: string;
  email_verified_at: string | null;
  created_at: string;
  updated_at: string;
  bids?: Bid[];
}

export interface Auction {
  id: number;
  name: string;
  starts_at: string;
  ends_at: string;
  created_at: string;
  updated_at: string;
  lots?: Lot[];
}

export interface Lot {
  id: number;
  auction_id: number;
  title: string;
  description: string | null;
  starting_price: number;
  current_price: number;
  created_at: string;
  updated_at: string;
  auction?: Auction;
  bids?: Bid[];
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

// Forms
export interface BidForm {
  lot_id: number;
  amount: number;
}

// Store States
export interface AuctionState {
  loading: boolean;
  storing: boolean;
  lots: Lot[];
  currentLot: Lot | null;
}
export type BreadcrumbItemType = BreadcrumbItem;
