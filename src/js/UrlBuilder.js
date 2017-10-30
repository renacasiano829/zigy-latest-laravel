class UrlBuilder {
    constructor(name, absolute) {

        this.name       = name;
        this.route      = Ziggy.namedRoutes[this.name];

        if (this.name === undefined) {
            throw new Error('Ziggy Error: You must provide a route name');
        } else if (this.route === undefined) {
            throw new Error(`Ziggy Error: route '${this.name}' is not found in the route list`);
        }

        this.absolute   = absolute === undefined ? true : absolute;
        this.domain     = this.setDomain();
        this.path       = this.route.uri.replace(/^\//, '');
    }

    setDomain() {
        if (! this.absolute)
            return '/';

        let host = (this.route.domain || Ziggy.baseDomain).replace(/\/+$/, '');

        if (Ziggy.basePort && (host.replace(/\/+$/, '') === Ziggy.baseDomain.replace(/\/+$/, '')))
            host = host + ':' + Ziggy.basePort;

        return Ziggy.baseProtocol + '://' + host + '/';
    }

    construct() {
        return this.domain + this.path
    }
}

export default UrlBuilder;
