'use client'; // Client-side component

import {store} from '@/lib/store'
import { Provider } from "react-redux";

if (process.env.NODE_ENV === "development") {
  (window as any).store = store;
}

export function Providers({ children }: { children: React.ReactNode }) {
  return <Provider store={store}>{children}</Provider>;
}

export default Providers;