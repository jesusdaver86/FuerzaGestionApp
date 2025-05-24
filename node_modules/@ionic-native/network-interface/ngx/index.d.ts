import { IonicNativePlugin } from '@ionic-native/core';
/**
 * @name Network Interface
 * @description
 * Network interface information plugin for Cordova/PhoneGap that supports Android, Blackberry 10, Browser, iOS, and Windows Phone 8.
 *
 * @usage
 * ```typescript
 * import { NetworkInterface } from '@ionic-native/network-interface/ngx';
 *
 * constructor( private networkInterface: NetworkInterface ) {
 *
 *   this.networkInterface.getWiFiIPAddress()
 *     .then(address => console.info(`IP: ${address.ip}, Subnet: ${address.subnet}`))
 *     .catch(error => console.error(`Unable to get IP: ${error}`));
 *
 *   this.networkInterface.getCarrierIPAddress()
 *     .then(address => console.info(`IP: ${address.ip}, Subnet: ${address.subnet}`))
 *     .catch(error => console.error(`Unable to get IP: ${error}`));
 *
 *   const url = 'www.github.com';
 *   this.networkInterface.getHttpProxyInformation(url)
 *     .then(proxy => console.info(`Type: ${proxy.type}, Host: ${proxy.host}, Port: ${proxy.port}`))
 *     .catch(error => console.error(`Unable to get proxy info: ${error}`));
 * }
 * ```
 */
export declare class NetworkInterface extends IonicNativePlugin {
    /**
     * Gets the WiFi IP address
     * @return {Promise<any>} Returns a Promise that resolves with the IP address information.
     */
    getWiFiIPAddress(): Promise<any>;
    /**
     * Gets the wireless carrier IP address
     * @return {Promise<any>} Returns a Promise that resolves with the IP address information.
     */
    getCarrierIPAddress(): Promise<any>;
    /**
     * Gets the relevant proxies for the passed URL in order of application
     * @param {url} message  The message to display.
     * @return {Promise<any>} Returns a Promise that resolves with the proxy information.
     */
    getHttpProxyInformation(url: string): Promise<any>;
}
